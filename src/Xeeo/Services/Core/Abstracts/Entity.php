<?php
/**
 * Entity.php
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

use \Xeeo\Services\Core\Abstracts\EntityInterface,
    \Xeeo\Services\Core\Abstracts\Entity\Field,
    \Xeeo\Services\Core\Abstracts\Entity\Exceptions\Field as FieldException,
    \Xeeo\Services\Core\Abstracts\CollectionInterface,
    \Xeeo\Services\Core\Abstracts\Collection;

/**
 * abstract class Entity
 *
 * @category  Services
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
abstract class Entity implements EntityInterface, \Iterator
{

    use Entity\Components\Iterator,
        Entity\Components\ExcludedClasses;

    /**
     * @var array
     */
    private $fields = array();

    /**
     * @var array
     */
    private $cleanFields = array();

    /**
     * @var array
     */
    private $cleanData = array();

    /**
     * Construct
     *
     * @param array $values An array with fieldName => value to setup at instantiating
     */
    public function __construct(array $values = array()) {

        $this->fields      = $this->initFields();
        $this->cleanFields = array_keys($this->fields);

        if (false === empty($values)) {
            $this->populateFromArray($values);
        }
    }

    /**
     * Returns a Field Instance
     *
     * @return Field
     */
    final public function field() {

        return new Field();
    }

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
    final public function setField($name, $value) {

        if (false === in_array($name, $this->cleanFields)) {
            throw new FieldException(
                sprintf(FieldException::MSG_FIELD_NOT_FOUND, $name),
                FieldException::CODE_FIELD_NOT_FOUND
            );
        }

        $this->fields[$name]->setName($name)->setValue($value);
        $this->cleanData[$name] = $value;

        return $this;
    }

    /**
     * Returns the Value for the Field with the name $name
     *
     * @param string $name The Name of the field you want the Value of
     *
     * @return mixed
     *
     * @throws FieldException
     */
    final public function getField($name) {

        if (false === in_array($name, $this->cleanFields)) {
            throw new FieldException(
                sprintf(FieldException::MSG_FIELD_NOT_FOUND, $name),
                FieldException::CODE_FIELD_NOT_FOUND
            );
        }

        return $this->fields[$name]->getValue();
    }

    /**
     * Returns a list with all Field Names
     *
     * @return array
     */
    final public function getFields() {

        return (array) $this->cleanFields;
    }

    /**
     * Returns a list with the fields as defined in initFields()
     *
     * @return array
     */
    final public function getData() {

        return $this->fields;
    }

    /**
     * Returns a list with the field names and value
     *
     * @return array
     */
    final public function getCleanData() {

        return $this->cleanData;
    }

    /**
     * This method validates the Entity.
     * Essentially it iterates all Fields and validates them.
     * If a Field has an error it throws an Exceptions
     *
     * @return void
     *
     * @throws FieldException
     */
    final public function validate() {

        foreach ($this->fields as $fieldName => $field) {
            $field->setName($fieldName)->validate();
        }
    }

    public function preSaveHook() {
    }

    public function postSaveHook() {
    }

    public function preDeleteHook() {
    }

    public function postDeleteHook() {
    }

    /**
     * Converts current Entity to an underline styled array
     *
     * @return array
     */
    final public function toUnderlineArray() {

        $bind           = array();
        $bind['__type'] = get_class($this);

        foreach ($this->fields as $fieldName => $fieldInstance) {
            if (is_object($fieldInstance->getValue()) && ($fieldInstance->getValue() instanceof self)) {
                $bind[self::toUnderline($fieldName, true)] = $fieldInstance->getValue()->toArray();
            } else if (false === is_null($fieldInstance->getValue())) {
                $bind[self::toUnderline($fieldName, true)] = $fieldInstance->getValue();
            } else {
                if (false === $fieldInstance->isIgnored()) {
                    $bind[self::toUnderline($fieldName, true)] = $fieldInstance->getValue();
                }
            }
        }

        return $bind;
    }

    /**
     * Converts camel case string to underline separated string
     *
     * @param string $string string to convert
     *
     * @return mixed|string
     */
    final public static function toUnderline($string) {

        $string = lcfirst($string);
        $result = preg_replace_callback(
            '/([A-Z])/',
            function ($matches) {

                return strtolower('_' . $matches[0]);
            },
            $string
        );

        return $result;
    }

    /**
     * Converts current Entity to an camel case styled array
     *
     * @return array
     */
    final public function toArray() {

        $bind           = array();
        $bind['__type'] = get_class($this);

        foreach ($this->fields as $fieldName => $field) {
            if (false === (is_null($field->getRawValue()) && $field->isIgnored())) {
                $bind[$fieldName] = $this->convertFieldToArray($field->getRawValue());
            }
        }

        return $bind;
    }

    private function convertFieldToArray($value) {

        switch (true) {
            case (($value instanceof EntityInterface) || ($value instanceof CollectionInterface)) :
                return $value->toArray();
                break;

            case (is_object($value) && $this->isClassExcluded($value)) :
                return $value;
                break;

            case (is_array($value) || is_object($value)) :
                return $this->convertMixedToArray($value);
                break;

            default :
                return $value;
        }
    }

    private function convertMixedToArray($mixed) {

        $bind = array();

        foreach ($mixed as $key => $value) {
            $bind[$key] = $this->convertFieldToArray($value);
        }

        return $bind;
    }


    /**
     * Converts underline separated string to camel case
     *
     * @param string $string              string to convert
     * @param bool   $capitaliseFirstChar first character to upper case?
     *
     * @return mixed|string
     */
    final public static function toCamelCase($string, $capitaliseFirstChar = false) {

        if ($capitaliseFirstChar) {
            $string = ucfirst($string);
        }

        $result = preg_replace_callback(
            "/_([a-z])/",
            function ($matches) {

                return strtoupper($matches[1]);
            },
            $string
        );

        return $result;
    }

    /**
     * Populates current Entity with the values from underline styled array
     *
     * @param array $values the array with the populate values
     *
     * @throws \Exception
     */
    final public function populateFromUnderlineArray(array $values) {

        foreach ($values as $key => $value) {
            $key = self::toCamelCase($key);

            $type = $this->fields[$key]->getType();

            if (is_array($value) && (false === is_null($type))) {
                if (strtolower($type) === 'collection') {
                    // @TODO
                } else {
                    try {
                        $instance = new $type();

                        $instance->populateFromArray($value);
                        $value = $instance;
                    } catch (\Exception $e) {
                        $value = null;
                    }
                }
            }

            $this->setField($key, $value);
        }
    }

    /**
     * Populates current Entity with the values from camel case styled array
     *
     * @param array $values the array with the populate values
     *
     * @throws \Exception
     *
     * @return void
     */
    final public function populateFromArray(array $values) {

        unset($values['__type']);

        foreach ($values as $key => $value) {
            $type = $this->fields[$key]->getType();

            if (is_array($value) && (false === is_null($type))) {
                unset($value['__type']);

                if (strtolower($type) === 'collection') {
                    try {
                        $collection = new Collection();

                        foreach($value['entities'] as $entityRawData) {
                            $entity = new $entityRawData['__type'];
                            unset($entityRawData['__type']);
                            $entity->populateFromArray($entityRawData);
                        }

                        $value = $collection;
                    } catch (\Exception $e) {
                        $value = null;
                    }
                } else {
                    try {
                        $instance = new $type();

                        $instance->populateFromArray($value);
                        $value = $instance;
                    } catch (\Exception $e) {
                        $value = null;
                    }
                }
            }

            $this->setField($key, $value);
        }
    }

    /**
     * Converts the data into serialized string
     *
     * @return void
     */
    final public function __toString() {

        return serialize($this->toArray());
    }
}
