<?php
/**
 * Collection.php
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
namespace Xeeo\Services\Core\Abstracts\Collection\Exceptions;

/**
 * class Collection
 *
 * @category  Services
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts\Collection\Exceptions
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
class Collection extends \Exception
{

    const MSG_PARAMETER_MUST_BE_FUNCTION  = 'The $callback parameter must be a function';
    const CODE_TYPE_INVALID = 1;
}
