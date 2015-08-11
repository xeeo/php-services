<?php
/**
 * CollectionInterface.php
 *
 * PHP version 5.5+
 *
 * @category  Services
 * @module    Core
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 * @link      https://bitbucket.org/xeeo/services
 */
namespace Xeeo\Services\Core\Abstracts;

/**
 * interface CollectionInterface
 *
 * @category  Services
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
interface CollectionInterface extends \Iterator, \ArrayAccess, \Countable {

    /**
     * Returns the entire Scheme or a Field from the Scheme
     *
     * Notice : The Scheme is an array with additional Fields got from the Query Result
     *
     * @param null|string $field The name for a certain field. If the Field does not exist it will return NULL
     *
     * @return mixed
     */
    public function getScheme($field = null);

    /**
     * Returns an Array with all Entities.
     * Useful for Debugging purpose
     *
     * @return array
     */
    public function getEntities();

    /**
     * Returns the Number Of Items in the Collection ignoring Offset and Limit
     *
     * @return int
     */
    public function countIgnoringOffsetAndLimit();

    /**
     * Returns TRUE if the Collection doesn't have any Entities in it
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Returns TRUE if the Collection has Entities in it
     *
     * @return bool
     */
    public function isNotEmpty();

    /**
     * IMPORTANT :: This function is used only internally in the library. Don't use it in your Code implementation
     *
     * Sets the total number of Items in the collection ignoring Offset and Limit
     *
     * @param int $count The total number of Items in the collection ignoring Offset and Limit
     *
     * @return $this
     */
    public function setCursorCount($count);

    /**
     * IMPORTANT :: This function is used only internally in the library. Don't use it in your Code implementation
     *
     * @param array $entities An array with Entities
     *
     * @return $this
     */
    public function setEntities(array $entities);

    /**
     * IMPORTANT :: This function is used only internally in the library. Don't use it in your Code implementation
     *
     * Sets the extra Scheme Fields returned by the Query
     *
     * @param array $scheme
     *
     * @return $this
     */
    public function setScheme(array $scheme);


    /**
    * Removes duplicate Entitites and returns the result in a Collection
    *
    * @return CollectionInterface
    */
    public function getUniqueEntities();

    /**
      * Removes an Entity or multiple Entities based on a Callback function
      * If the Callback function returns TRUE the Entity is removed
      *
      * @param function $callbackFunction This is the Callback function
      *
      * @return void
      */
    public function removeEntities($callbackFunction);

    /**
     * Converts current Collection including all Entities to an Array
     *
     * @return array
     */
    public function toArray();
}
