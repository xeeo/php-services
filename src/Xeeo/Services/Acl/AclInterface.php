<?php
/**
 * AclInterface.php
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

interface AclInterface {

    public function init($config = null);

    public function throwExceptionForUndefinedResouce($booleanFlag);

    public function throwExceptionForUndefinedPermission($booleanFlag);

    public function setDefaultValue($booleanFlag);

    public function trueOverwrites($booleanFlag);

    public function setRules($rules);

    public function canAccess($resource, $permissionTypes);

    public function canNotAccess($resource, $permissionTypes);

}
