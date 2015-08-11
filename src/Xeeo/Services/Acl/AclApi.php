<?php
/**
 * AclApi.php
 *
 * PHP version 5.5+
 *
 * @category  Services
 * @module    Acl
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 * @link      https://bitbucket.org/xeeo/services
 */
namespace Xeeo\Services\Acl;

use \Xeeo\Services\Core\Patterns\Singleton as SingletonPattern,
    \Xeeo\Services\Core\Patterns\SingletonInterface as SingletonPatternInterface,
    \Xeeo\Services\Acl\Components\Config,
    \Xeeo\Services\AclAclException;

/**
 * class AclApi
 *
 * @category  Services
 * @module    Acl
 * @package   Xeeo\Services\Acl
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
class AclApi implements AclInterface, SingletonPatternInterface
{
    use SingletonPattern,
        Config;

    private $rules           = array();
    private $permissionTypes = array();
    private $resources       = array();

    /**
     * This function is called when a new Instance of this object is created
     *
     * @param array|null $config The configuration parameters
     *
     * @return void
     */
    public function init($config = null) {
        $this->initializeConfig($config);
    }

    private function checkPermissionExistance($permissionType) {

        if ($this->throwExceptionForUndefinedPermission) {
            if (false === isset($this->rules[$permissionType])) {
                throw new AclException(
                    sprintf(AclException::MSG_PERMISSION_TYPE_NOT_EXISTS, $permissionType),
                    AclException::CODE_PERMISSION_TYPE_NOT_EXISTS
                );
            }
        }
    }

    private function checkResourceExistance($resouce) {

        if ($this->throwExceptionForUndefinedResouce) {
            if (false === in_array($resouce, $this->resources)) {
                throw new AclException(
                    sprintf(AclException::MSG_RESOURCE_NOT_EXISTS, $resouce),
                    AclException::CODE_RESOURCE_NOT_EXISTS
                );
            }
        }
    }

    private function verifyRule($permissionType, $resource) {

        $this->checkPermissionExistance($permissionType);

        if (isset($this->rules[$permissionType][$resource])) {
            $canAccess = $this->rules[$permissionType][$resource];
        } else {
            $canAccess = false;
        }

        return $canAccess;
    }

    public function canAccess($resource, $permissionTypes) {

        $this->checkResourceExistance($resource);

        if (false === is_array($permissionTypes)) {
            $permissionTypes = array($permissionTypes);
        }

        $canAccess = false;

        foreach($permissionTypes as $permissionType) {
            $canAccess = $this->verifyRule($permissionType, $resource);

            if ($this->trueOverwrites && $canAccess) {
                return true;
            }

            if ((false === $this->trueOverwrites) && (false === $canAccess)) {
                return false;
            }
        }

        return $canAccess;
    }

    public function canNotAccess($resource, $permissionTypes) {
        $canAccess = $this->canAccess($resource, $permissionTypes);

        return !$canAccess;
    }
}
