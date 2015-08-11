<?php
/**
 * Field.php
 *
 * PHP version 5.5+
 *
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts\Entity
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Core\Abstracts\Entity;

use \Xeeo\Services\Core\Abstracts\Entity\Exceptions\Field as FieldException,
    \Xeeo\Services\Core\Abstracts\EntityInterface,
    \Xeeo\Services\Core\Abstracts\CollectionInterface,
    \Xeeo\Services\Database\MapperInterface;

class Field
{
    private $name = null;
    private $ignore = false;
    private $required = false;
    private $notEmpty = false;
    private $value = null;
    private $validators = array();
    private $filters = array();
    private $type = null;
    private $isReference = false;
    private $referenceMapper = null;

    public function setName($name) {

        $this->name = $name;

        return $this;
    }

    public function getName() {

        return $this->name;
    }

    private function throwTypeInvalidException($requiredType, $value) {

        $type = (is_object($value)) ? get_class($value) : gettype($value);

        throw new FieldException(sprintf(
                FieldException::MSG_TYPE_INVALID,
                $requiredType,
                $type
            ), FieldException::CODE_TYPE_INVALID);
    }

    public function setReference($mapper) {

        if (false === ($mapper instanceof MapperInterface)) {
            $this->throwTypeInvalidException('\Xeeo\Services\Database\MapperInterface', $mapper);
        }

        $this->isReference     = true;
        $this->referenceMapper = $mapper;

        return $this;
    }

    public function addValidator($validator) {

        $this->validators[] = $validator;
    }

    public function addFilters($filter) {

        $this->filters[] = $filter;
    }

    public function setIgnore($ignore = true) {

        if (false === is_bool($ignore)) {
            $this->throwTypeInvalidException('boolean', $ignore);
        }

        $this->ignore = (bool) $ignore;

        return $this;
    }

    public function setNotEmpty($notEmpty = true) {

        if (false === is_bool($notEmpty)) {
            $this->throwTypeInvalidException('boolean', $notEmpty);
        }

        $this->notEmpty = (bool) $notEmpty;

        return $this;
    }

    public function setRequired($required = true) {

        if (false === is_bool($required)) {
            $this->throwTypeInvalidException('boolean', $required);
        }

        $this->required = (bool) $required;

        return $this;
    }

    public function setValue($value) {

        if ($this->isReference && ($value instanceof EntityInterface)) {
            $mapper = $this->referenceMapper;
            $value  = $mapper::createReference($value);
        }

        $this->value = $value;
        $this->validate();

        return $this;
    }

    public function getRawValue() {

        return $this->value;
    }

    public function getValue() {

        $value = $this->getRawValue();

        if (empty($value)) {
            return $value;
        }

        if ($this->isReference) {
            $mapper = $this->referenceMapper;

            return $mapper::getReferencedEntity($value);
        }

        return $value;
    }

    public function setType($type) {

        $this->type = $type;

        return $this;
    }

    public function getType() {

        return $this->type;
    }

    private function validateRequired() {

        if (is_null($this->value)) {
            throw new FieldException(sprintf(
                    FieldException::MSG_FIELD_REQURIED,
                    $this->name
                ), FieldException::CODE_FIELD_REQURIED);
        }
    }

    private function validateReference() {

        $mapper = $this->referenceMapper;
        $value  = $this->getRawValue();

        if (false === $mapper::isReference($value)) {
            $this->throwTypeInvalidException('*reference*', $value);
        }
    }

    private function validateNotEmpty() {

        switch (true) {
            case ($this->value instanceof EntityInterface) :
                $isEmpty = empty($this->value->getCleanData());
                break;
            case ($this->value instanceof CollectionInterface) :
                $isEmpty = empty($this->value->getEntities());
                break;
            default:
                $isEmpty = empty($this->value);
                break;
        }

        if ($isEmpty) {
            throw new FieldException(
                sprintf(FieldException::MSG_FIELD_EMPTY, $this->name),
                FieldException::CODE_FIELD_EMPTY
            );
        }
    }

    public function isIgnored() {

        return (bool) $this->ignore;
    }

    private function validateType() {

        switch (true) {
            case ($this->isTypeEmpty()) :
            case ($this->isTypeMatching()) :
            case ($this->isClassMatching()) :
            case ($this->isCollectionMatching()) :
                return true;
                break;

            default :
                $this->throwTypeInvalidException($this->type, $this->getRawValue());
                break;
        }
    }

    private function isTypeEmpty() {

        $expectedType = strtolower($this->type);

        return is_null($expectedType);
    }

    private function isTypeMatching() {

        $expectedType = strtolower($this->type);
        $type         = gettype($this->getRawValue());

        return ($expectedType == $type);
    }

    private function isClassMatching() {

        $value        = $this->getRawValue();
        $type         = get_class($value);

        return (is_object($value) && ($this->type == $type));
    }

    private function isCollectionMatching() {

        $expectedType = strtolower($this->type);
        $value        = $this->getRawValue();

        return (($expectedType === 'collection') && ($value instanceof CollectionInterface));
    }

    public function validate() {

        if ((is_null($this->getRawValue()) && $this->isIgnored())) {
            return $this;
        }

        if ($this->isReference) {
            $this->validateReference();
            return $this;
        }

        if ($this->required) {
            $this->validateRequired();
        }

        if (false === is_null($this->type)) {
            $this->validateType();
        }

        if ($this->notEmpty) {
            $this->validateNotEmpty();
        }

        return $this;
    }
}
