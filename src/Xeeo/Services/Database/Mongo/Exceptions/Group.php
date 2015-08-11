<?php
/**
 * Group.php
 *
 * PHP version 5.5+
 *
 * @module    Database
 * @package   Xeeo\Services\Database\Mongo\Exceptions
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Database\Mongo\Exceptions;

class Group extends \Exception {

    const MSG_WRONG_OPERATOR  = 'Operator must be one of he following : (%s)';
    const CODE_WRONG_OPERATOR = 1;

}
