<?php
/**
 * Credentials.php
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

class Credentials extends \Exception {

    const MSG_IDENTIFIER_FIELD_NOT_SET  = 'Field for Identifier not set';
    const CODE_IDENTIFIER_FIELD_NOT_SET = 1;

    const MSG_IDENTIFIER_VALUE_NOT_SET  = 'Value for Identifier not set';
    const CODE_IDENTIFIER_VALUE_NOT_SET = 2;

    const MSG_PASSWORD_FIELD_NOT_SET  = 'Field for Password not set';
    const CODE_PASSWORD_FIELD_NOT_SET = 3;

    const MSG_PASSWORD_VALUE_NOT_SET  = 'Value for Password not set';
    const CODE_PASSWORD_VALUE_NOT_SET = 4;


}
