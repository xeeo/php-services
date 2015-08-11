<?php
/**
 * Mapper.php
 *
 * PHP version 5.5+
 *
 * @module    Database
 * @package   Xeeo\Services\Database\Mongo
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Database\Mongo;

use \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity,
    \Xeeo\Services\Core\Abstracts\Collection as AbstractCollection,
    \Xeeo\Services\Database\MapperInterface,
    \Xeeo\Services\Database\MapperException,
    \Xeeo\Services\Database\FilterInterface,
    \Xeeo\Services\Database\Mongo\Filter,
    \Xeeo\Services\Database\Mongo\Group,
    \Xeeo\Services\Core\Abstracts\EntityInterface,
    \Xeeo\Services\Core\Abstracts\CollectionInterface;

abstract class Mapper implements MapperInterface
{
    use Components\Connection,
        Components\Collection,
        Components\Entity,
        Components\Hooks,
        Components\Reference;

    private static $defaultConnectionName = 'default';

    public static function getFilter($key, $comparator, $value) {

        return Filter::set($key, $comparator, $value);
    }

    public static function getGroup(FilterInterface $firstCondition, $operator, FilterInterface $secondCondition) {

        return Group::set($firstCondition, $operator, $secondCondition);
    }

    public static function findOne(FilterInterface $criteria = null, array $fields = array()) {

        $collection = self::getCollection();
        $statement  = array();

        try {
            if (false === is_null($criteria)) {
                $statement = $criteria->getStatement();
            }

            $rawEntity = $collection->findOne($statement, $fields);

            if (is_null($rawEntity)) {
                return null;
            }

            $entity = self::createObject($rawEntity);
        } catch (\Exception $e) {
            throw new MapperException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $entity;
    }

    public static function get($entityId) {

        if (false === ($entityId instanceof \MongoId)) {
            $entityId = new \MongoId((string) $entityId);
        }

        $criteria = Filter::set('_id', Filter::EQUAL, $entityId);

        try {
            $entity = self::findOne($criteria);
        } catch (\Exception $e) {
            throw new MapperException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $entity;
    }

    /**
     * @param FilterInterface $criteria
     * @param int             $limit
     * @param int             $offset
     * @param array           $sort
     * @param array           $fields
     *
     * @return AbstractCollection
     * @throws MapperException
     */
    public static function find(FilterInterface $criteria = null, $limit = 10, $offset = 0, array $sort = array(), array $fields = array()) {

        $collection       = self::getCollection();
        $limit            = (int) $limit;
        $offset           = (int) $offset;
        $entityCollection = new AbstractCollection();
        $statement        = array();

        try {
            if (false === is_null($criteria)) {
                $statement = $criteria->getStatement();
            }

            $cursor = $collection->find($statement, $fields);

            switch (true) {
                case ($limit >= 0) :
                    $cursor = $cursor->limit($limit);
                case ($offset > 0) :
                    $cursor = $cursor->skip($offset);
                case (false === empty($sort)) :
                    $cursor = $cursor->sort($sort);
            }

            $entityCollection->setCursorCount($cursor->count());

            foreach ($cursor as $rawEntity) {
                $entityCollection[] = self::createObject($rawEntity);
            }

            $cursor->reset();
        } catch (\Exception $e) {
            throw new MapperException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $entityCollection;
    }
    
    public static function aggregate(array $pipeline, array $options = array()) {
        
        $collection = self::getCollection();

        return $collection->aggregate($pipeline, $options);
    }

    public static function count(FilterInterface $criteria) {

        $collection = self::getCollection();

        try {
            $result = $collection->count($criteria->getStatement());
        } catch (\Exception $e) {
            throw new MapperException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $result;
    }

    public static function save(AbstractEntity $entity, array $options = array()) {

        $collection = self::getCollection();

        $entity->validate();

        self::callPreSaveHook($entity);
        $entityToSave = $entity->toArray();

        try {
            $collection->save($entityToSave, $options);
            $entity->setField('_id', $entityToSave['_id']);

            self::callPostSaveHook($entity);
        } catch (\Exception $e) {
            throw new MapperException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $entity;
    }

    private static function createObject(array $rawData) {

        if (false === isset($rawData['__type'])) {
            return $rawData;
        }

        $object = new $rawData['__type']();
        unset($rawData['__type']);

        switch (true) {
            case ($object instanceof EntityInterface) :
                foreach ($rawData as $field => $value) {

                    if (is_array($value)) {
                        $subEntity = self::createObject($value);
                        $object->setField($field, $subEntity);
                    } else {
                        $object->setField($field, $value);
                    }
                }
                break;

            case ($object instanceof CollectionInterface) :
                foreach ($rawData['entities'] as $rawEntity) {
                    $object[] = self::createObject($rawEntity);
                }
                break;
        }

        return $object;
    }

    public static function delete(FilterInterface $criteria, array $options = array()) {

        $collection = self::getCollection();

        try {
            $result = $collection->remove($criteria->getStatement(), $options);
        } catch (\Exception $e) {
            throw new MapperException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $result;
    }
}
