<?php
/**
 * Database.php
 *
 * PHP version 5.5+
 *
 * @module    Authenticate
 * @package   Xeeo\Services\Authenticate\Components
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Authenticate\Components;

use \Xeeo\Services\Authenticate\Exceptions\Database as DatabaseException,
    \Xeeo\Services\Database\MapperInterface,
    \Xeeo\Services\Database\Mongo\Filter;

trait Database {

    private $mapper = null;

    private $constraints = array();

    /**
     *
     * @return MapperInterface
     */
    public function getMapper() {
        return (!is_null($this->mapper)) ? $this->mapper : null;
    }

    private function validateMapperExistence($mapper) {
        try {
            return class_exists($mapper);
        } catch (\Exception $e) {
            throw new DatabaseException(
                sprintf(DatabaseException::MSG_MAPPER_NOT_FOUND, $mapper),
                DatabaseException::CODE_MAPPER_NOT_FOUND
            );
        }
    }

    private function validateMapperType($mapper) {
        if (false === ($mapper instanceof MapperInterface)) {
            throw new DatabaseException(
                sprintf(DatabaseException::MSG_MAPPER_INVALID_TYPE, $mapper),
                DatabaseException::CODE_MAPPER_INVALID_TYPE
            );
        }

        return true;
    }

    public function setMapper($mapper) {
        $this->validateMapperExistence($mapper);
        $mapperInstance = new $mapper();
        $this->validateMapperType($mapperInstance);

        $this->mapper = $mapperInstance;

        return $this;
    }

    protected function validateMapperField() {
        if (is_null($this->getMapper())) {
            throw new DatabaseException(
                DatabaseException::MSG_MAPPER_NOT_SET,
                DatabaseException::CODE_MAPPER_NOT_SET
            );
        }
    }

    public function setConstraints(Filter $constraints = null) {
        $this->constraints = (empty($constraints)) ? array() : $constraints;

        return $this;
    }
}



