<?php
/**
 * Collection.php
 *
 * PHP version 5.5+
 *
 * @module    Core
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
namespace Xeeo\Services\Core\Abstracts;

use \Xeeo\Services\Core\Abstracts\CollectionInterface,
    \Xeeo\Services\Core\Abstracts\Collection\Exceptions\Collection as CollectionException;

/**
 * class Collection
 *
 * PHP version 5.5+
 *
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
class Collection implements CollectionInterface {

    use Collection\Components\Iterator,
        Collection\Components\ArrayAccess,
        Collection\Components\Countable;

    /**
     * @var array
     */
    private $entities = array();

    /**
     * @var array
     */
    private $scheme = array();

    /**
     * @var int
     */
    private $count = 0;

    /**
     * Returns the entire Scheme or a Field from the Scheme
     *
     * Notice : The Scheme is an array with additional Fields got from the Query Result
     *
     * @param null|string $field The name for a certain field. If the Field does not exist it will return NULL
     *
     * @return mixed
     */
    final public function getScheme($field = null) {

        $schemeResult = null;

        if ((false === is_null($field))) {
            if (isset($this->scheme[$field])) {
                $schemeResult = $this->scheme[$field];
            }
        } else {
            $schemeResult = $this->scheme;
        }

        return $schemeResult;
    }

    /**
     * Returns an Array with all Entities.
     * Useful for Debugging purpose
     *
     * @return array
     */
    final public function getEntities() {
        return (array) $this->entities;
    }

    /**
     * Returns the Number Of Items in the Collection ignoring Offset and Limit
     *
     * @return int
     */
    final public function countIgnoringOffsetAndLimit() {

        return (int) $this->count;
    }

    /**
     * Removes duplicate Entitites and returns the result in a Collection
     *
     * @return CollectionInterface
     */
    final public function getUniqueEntities() {

        $clone          = clone $this;
        $uniqueEntities = array_unique($this->entities);

        $clone->setEntities($uniqueEntities);
        $clone->setCursorCount(count($uniqueEntities));

        return $clone;
    }

    /**
     * Returns TRUE if the Collection doesn't have any Entities in it
     *
     * @return bool
     */
    final public function isEmpty() {
        return ($this->count() === 0);
    }

    /**
     * Returns TRUE if the Collection has Entities in it
     *
     * @return bool
     */
    final public function isNotEmpty() {
        return (false === $this->isEmpty());
    }

    /**
     * IMPORTANT :: This function is used only internally in the library. Don't use it in your Code implementation
     *
     * Sets the total number of Items in the collection ignoring Offset and Limit
     *
     * @param int $count The total number of Items in the collection ignoring Offset and Limit
     *
     * @return $this
     */
    final public function setCursorCount($count) {
        $this->count = (int) $count;

        return $this;
    }

    /**
     * IMPORTANT :: This function is used only internally in the library. Don't use it in your Code implementation
     *
     * @param array $entities An array with Entities
     *
     * @return $this
     */
    final public function setEntities(array $entities) {
        $this->entities = $entities;

        return $this;
    }

    /**
     * IMPORTANT :: This function is used only internally in the library. Don't use it in your Code implementation
     *
     * Sets the extra Scheme Fields returned by the Query
     *
     * @param array $scheme
     *
     * @return $this
     */
    final public function setScheme(array $scheme) {
        $this->scheme = $scheme;

        return $this;
    }

    /**
      * Removes an Entity or multiple Entities based on a Callback function
      * If the Callback function returns TRUE the Entity is removed
      *
      * @param function $callbackFunction This is the Callback function
      *
      * @return void
      */
    final public function removeEntities($callbackFunction) {

        if (false === is_callable($callbackFunction)) {
            throw new CollectionException(
                CollectionException::MSG_PARAMETER_MUST_BE_FUNCTION,
                CollectionException::CODE_TYPE_INVALID
            );
        }

        foreach ($this->entities as $key => $entity) {
            if ($callbackFunction($entity)) {
                unset($this->entities[$key]);
            }
        }

        $this->entities = array_values($this->entities);
    }


    /**
     * Converts current Collection including all Entities to an Array
     *
     * @return array
     */
    final public function toArray() {

        $bind           = array();
        $entities       = array();
        $bind['__type'] = get_class($this);

        foreach ($this->entities as $entity) {
            if (method_exists($entity, 'toArray')) {
                $entity = $entity->toArray();
            }

            $entities[] = $entity;
        }

        $bind['entities'] = $entities;

        return $bind;
    }

}
