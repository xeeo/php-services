<?php
/**
 * AuthenticateApi.php
 *
 * PHP version 5.5+
 *
 * @category  Services
 * @module    Authenticate
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 * @link      https://bitbucket.org/xeeo/services
 */
namespace Xeeo\Services\Authenticate;

use \Xeeo\Services\Core\Patterns\Singleton as SingletonPattern,
    \Xeeo\Services\Core\Patterns\SingletonInterface as SingletonPatternInterface,
    \Xeeo\Services\Authenticate\Exceptions\Authenticate as AuthenticateException,
    \Xeeo\Services\Authenticate\AuthenticateInterface,
    \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity,
    \Xeeo\Services\Database\Mongo\Filter,
    \Xeeo\Services\Database\Mongo\Group;

/**
 * class AuthenticateApi
 *
 * @category  Services
 * @module    Authenticate
 * @package   Xeeo\Services\Authenticate
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
class AuthenticateApi implements AuthenticateInterface, SingletonPatternInterface
{
    use SingletonPattern,
        Components\HashAlgorithm,
        Components\Credentials,
        Components\Database;

    const USER_STATUS_ACTIVE   = 'active';
    const USER_STATUS_INACTIVE = 'inactive';
    const USER_STATUS_PENDING  = 'pending';
    const USER_STATUS_DELETED  = 'deleted';

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

    private function getUserByIdentifier() {

        $mapper = $this->getMapper();

        if (empty($this->constraints)) {
            $user = $mapper::findOne(
                Filter::set(
                    $this->getIdentifierField(), 
                    Filter::EQUAL, 
                    $this->getIdentifierValue()
                )
            );
        } else {
            $user = $mapper::findOne(
                Group::set(
                    Filter::set(
                        $this->getIdentifierField(), 
                        Filter::EQUAL, 
                        $this->getIdentifierValue()
                    ),
                    Group::OPERATOR_AND,
                    $this->constraints
                )
            );
        }

        return $user;
    }

    public function authenticate() {

        $this->validateMapperField();
        $this->validateIdentifierField();
        $this->validatePasswordField();

        $user = $this->getUserByIdentifier();

        $this->validateUserExistence($user);
        if (false === $this->isPasswordIgnored()) {
            
            $passwordFieldArray = explode(".", $this->getPasswordField());
            $subInstance        = $user;

            foreach ($passwordFieldArray as $fieldBlock) {
                $subInstance = $subInstance->getField($fieldBlock);
            }
           
            $this->validatePassword(
                $this->getPasswordValue(), 
                $subInstance
            );
        }
        $this->validateUserStatus($user);

        return true;
    }

    private function validateUserExistence($user) {

        if (is_null($user) || (false === ($user instanceof AbstractEntity))) {
            throw new AuthenticateException(
                AuthenticateException::MSG_USER_NOT_FOUND,
                AuthenticateException::CODE_USER_NOT_FOUND
            );
        }
    }

    private function validateUserStatus($user) {

        switch ($user->getField('status')) {
            case self::USER_STATUS_ACTIVE :
                $auth        = \Zend_Auth::getInstance();
                $authStorage = $auth->getStorage();
                $authStorage->write($user->getField('_id'));
                break;
            default :
                $this->throwUserStatusException($user->getField('status'));
                break;
        }

        return true;
    }

    private function throwUserStatusException($userStatus) {

        switch ($userStatus) {
            case self::USER_STATUS_PENDING :
                throw new AuthenticateException(
                    AuthenticateException::MSG_STATUS_PENDING,
                    AuthenticateException::CODE_STATUS_PENDING
                );
                break;
            case self::USER_STATUS_INACTIVE :
                throw new AuthenticateException(
                    AuthenticateException::MSG_STATUS_INACTIVE,
                    AuthenticateException::CODE_STATUS_INACTIVE
                );
                break;
            case self::USER_STATUS_DELETED :
                throw new AuthenticateException(
                    AuthenticateException::MSG_STATUS_DELETED,
                    AuthenticateException::CODE_STATUS_DELETED
                );
                break;
            default :
                throw new AuthenticateException(
                    AuthenticateException::MSG_UNKNOWN_STATUS,
                    AuthenticateException::CODE_UNKNOWN_STATUS
                );
                break;
        }
    }

}