<?php
/**
 * Config.php
 *
 * PHP version 5.5+
 *
 * @category  Services
 * @module    Acl
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 * @link      https://bitbucket.org/xeeo/services
 */
namespace Xeeo\Services\Acl\Components;

use \Xeeo\Services\Core\Abstracts\CollectionInterface,
    \Xeeo\Services\Acl\Exceptions\Acl as AclException;

/**
 * trait Config
 *
 * @category  Services
 * @module    Acl
 * @package   Xeeo\Services\Acl\Components
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait Config
{
    private $defaultValue                         = true;
    private $throwExceptionForUndefinedResouce    = false;
    private $throwExceptionForUndefinedPermission = false;
    private $trueOverwrites                       = true;

    public function throwExceptionForUndefinedResouce($booleanFlag) {
        $this->throwExceptionForUndefinedResouce = (bool) $booleanFlag;

        return $this;
    }

    public function throwExceptionForUndefinedPermission($booleanFlag) {
        $this->throwExceptionForUndefinedPermission = (bool) $booleanFlag;

        return $this;
    }

    public function setDefaultValue($booleanFlag) {
        $this->defaultValue = (bool) $booleanFlag;

        return $this;
    }

    public function trueOverwrites($booleanFlag) {
        $this->trueOverwrites = (bool) $booleanFlag;

        return $this;
    }

    public function setRules($rules) {
        $this->rules = (array) $rules;
        $this->rules = $this->prepareRules($this->rules);

        return $this;
    }

    private function prepareRules($rules) {

        foreach($rules as $permissionType => $resources) {
            foreach($resources as $key => $value) {
                if (is_string($key)) {
                    $this->resources[]            = $key;
                    $rules[$permissionType][$key] = (bool) $value;
                } else {
                    unset($rules[$permissionType][$key]);
                    $this->resources[]              = $value;
                    $rules[$permissionType][$value] = (bool) $this->defaultValue;
                }
            }
        }

        return $rules;
    }



}
