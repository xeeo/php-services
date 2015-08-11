<?php
/**
 * Field.php
 *
 * PHP version 5.5+
 *
 * @category  Services
 * @module    Core
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 * @link      https://bitbucket.org/xeeo/services
 */
namespace Xeeo\Services\Core\Abstracts\Entity\Exceptions;

/**
 * class Field
 *
 * @category  Services
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts\Entity\Exceptions
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
class Field extends \Exception
{

    const MSG_TYPE_INVALID  = 'Type is invalid. -%s- expected but -%s- given';
    const CODE_TYPE_INVALID = 1;

    const MSG_FIELD_REQURIED  = 'The field -%s- is required';
    const CODE_FIELD_REQURIED = 2;

    const MSG_FIELD_EMPTY  = 'The field -%s- can\'t be empty';
    const CODE_FIELD_EMPTY = 3;

    const MSG_FIELD_NOT_FOUND  = 'The field -%s- does not exist in Entity';
    const CODE_FIELD_NOT_FOUND = 4;
}
