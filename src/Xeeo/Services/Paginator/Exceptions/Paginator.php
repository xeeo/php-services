<?php
/**
 * Paginator.php
 *
 * PHP version 5.5+
 *
 * @category  Services
 * @module    Paginator
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 * @link      https://bitbucket.org/xeeo/services
 */
namespace Xeeo\Services\Paginator\Exceptions;

use \Xeeo\Services\Paginator\PaginatorApi;

/**
 * class Paginator
 *
 * @category  Services
 * @module    Paginator
 * @package   Xeeo\Services\Authenticate\Exceptions
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
class Paginator extends \Exception
{

    const MSG_TEMPLATE_NOT_FOUND  = 'Template -%s- doesn\'t exist';
    const CODE_TEMPLATE_NOT_FOUND = 1;

    const MSG_COLLECTION_NOT_SET  = 'There is no Collection set';
    const CODE_COLLECTION_NOT_SET = 2;

    const MSG_WRONG_URL_PATTERN  = 'The UrlPattern must contain %s';
    const CODE_WRONG_URL_PATTERN = 3;
}
