<?php
/**
 * EntityInterface.php
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

use \Xeeo\Services\Core\Abstracts\Entity\Components\Field,
    \Xeeo\Services\Core\Abstracts\Entity\Exceptions\Field as FieldException;

/**
 * interface EntityInterface
 *
 * @category  Services
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
interface EntityInterface
{

    /**
     * This function needs to return an Array with all the Fields that the Entity will have with the associated Rules
     *
     * @return array
     */
    public function initFields();

    /**
     * Returns a Field Instance
     *
     * @return Field
     */
    public function field();

    /**
     * Sets the value $value for a Field with the name $name
     *
     * @param string $name  The Name of the Filed
     * @param mixed  $value The Value of the Filed
     *
     * @return $this
     *
     * @throws FieldException
     */
    public function setField($name, $value);

    /**
     * Returns the Value for the Field with the name $name
     *
     * @param string $name The Name of the field you want the Value of
     *
     * @return mixed
     *
     * @throws FieldException
     */
    public function getField($name);

    /**
     * Returns a list with all Field Names
     *
     * @return array
     */
    public function getFields();

    public function preSaveHook();

    public function postSaveHook();

    public function preDeleteHook();

    public function postDeleteHook();

    /**
     * Returns a list with the fields as defined in initFields()
     *
     * @return array
     */
    public function getData();

    /**
     * Returns a list with the field names and value
     *
     * @return array
     */
    public function getCleanData();

    /**
     * This method validates the Entity.
     * Essentially it iterates all Fields and validates them.
     * If a Field has an error it throws an Exceptions
     *
     * @return void
     *
     * @throws FieldException
     */
    public function validate();

    /**
     * Converts current Entity to an underline styled array
     *
     * @return array
     */
    public function toUnderlineArray();

    /**
     * Converts camel case string to underline separated string
     *
     * @param string $string string to convert
     *
     * @return mixed|string
     */
    public static function toUnderline($string);

    /**
     * Converts current Entity to an camel case styled array
     *
     * @return array
     */
    public function toArray();

    /**
     * Converts underline separated string to camel case
     *
     * @param string $string              string to convert
     * @param bool   $capitaliseFirstChar first character to upper case?
     *
     * @return string
     */
    public static function toCamelCase($string, $capitaliseFirstChar = false);

    /**
     * Populates current Entity with the values from underline styled array
     *
     * @param array $values the array with the populate values
     *
     * @throws \Exception
     */
    public function populateFromUnderlineArray(array $values);

    /**
     * Populates current Entity with the values from camel case styled array
     *
     * @param array $values the array with the populate values
     *
     * @throws \Exception
     */
    public function populateFromArray(array $values);
}
