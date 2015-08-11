<?php
/**
 * Login.php
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

class Authenticate extends \Exception {

    const MSG_USER_NOT_FOUND  = 'User not found';
    const CODE_USER_NOT_FOUND = 1;

    const MSG_WRONG_PASSWORD  = 'Wrong Password';
    const CODE_WRONG_PASSWORD = 2;

    const MSG_STATUS_PENDING  = 'User account is pending activation';
    const CODE_STATUS_PENDING = 3;

    const MSG_STATUS_INACTIVE  = 'User account is inactive';
    const CODE_STATUS_INACTIVE = 4;

    const MSG_STATUS_DELETED  = 'User account was deleted';
    const CODE_STATUS_DELETED = 5;

    const MSG_UNKNOWN_STATUS  = 'User status unknown';
    const CODE_UNKNOWN_STATUS = 6;
}
