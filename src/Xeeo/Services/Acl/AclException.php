<?php
/**
 * AclException.php
 *
 * PHP version 5.5+
 *
 * @module    Acl
 * @package   Xeeo\Services\Acl
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Acl;

class AclException extends \Exception {

    const MSG_PERMISSION_TYPE_NOT_EXISTS  = "Permission type %s does not exist.";
    const CODE_PERMISSION_TYPE_NOT_EXISTS = 1;

    const MSG_RESOURCE_NOT_EXISTS  = "Resource type %s does not exist for called Permission Type.";
    const CODE_RESOURCE_NOT_EXISTS = 2;

}
