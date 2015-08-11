<?php
/**
 * MapperInterface.php
 *
 * PHP version 5.5+
 *
 * @module    Database
 * @package   Xeeo\Services\Database
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Database;

use \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity, \Xeeo\Services\Database\FilterInterface;

interface MapperInterface
{
    public static function findOne(FilterInterface $criteria = null, array $fields = array());

    public static function find(FilterInterface $criteria = null, $limit = 10, $offset = 0, array $sort = array(), array $fields = array());

    public static function count(FilterInterface $criteria);

    public static function get($entityId);

    public static function delete(FilterInterface $criteria, array $options = array());

    public static function save(AbstractEntity $entity, array $options = array());

    public static function getFilter($key, $comparator, $value);

    public static function getGroup(FilterInterface $firstCondition, $operator, FilterInterface $secondCondition);
}
