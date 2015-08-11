<?php
/**
 * Database.php
 *
 * PHP version 5.5+
 *
 * @module    Authenticate
 * @package   Xeeo\Services\Authenticate\Exceptions
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Authenticate\Exceptions;

class Database extends \Exception {

    const MSG_MAPPER_NOT_SET  = 'The Mapper for Authentication Service is not set';
    const CODE_MAPPER_NOT_SET = 1;

    const MSG_MAPPER_NOT_FOUND  = 'Mapper \'%s\' does not exist';
    const CODE_MAPPER_NOT_FOUND = 2;

    const MSG_MAPPER_INVALID_TYPE  = 'Mapper \'%s\' does not implement a MapperInterface';
    const CODE_MAPPER_INVALID_TYPE = 3;
}
