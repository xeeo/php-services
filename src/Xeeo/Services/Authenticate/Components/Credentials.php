<?php
/**
 * Credentials.php
 *
 * PHP version 5.5+
 *
 * @module    Authenticate
 * @category  Services
 * @package   Xeeo\Services\Authenticate\Components
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Authenticate\Components;

use \Xeeo\Services\Authenticate\Exceptions\Credentials as CredentialsException;

trait Credentials {

    private $identifierField = null;
    private $identifierValue = null;
    private $passwordField = null;
    private $passwordValue = null;
    private $ignorePassword = false;

    public function isPasswordIgnored() {
        return (bool) $this->ignorePassword;
    }

    public function ignorePassword($ignorePassword) {
        $this->ignorePassword = (bool) $ignorePassword;

        return $this;
    }

    public function getIdentifierField() {
        return (!is_null($this->identifierField)) ? (string) $this->identifierField : null;
    }

    public function setIdentifierField($identifierField) {
        $this->identifierField = (string) $identifierField;

        return $this;
    }

    public function getIdentifierValue() {
        return (!is_null($this->identifierValue)) ? (string) $this->identifierValue : null;
    }

    public function setIdentifierValue($identifierValue) {
        $this->identifierValue = (string) $identifierValue;

        return $this;
    }

    public function getPasswordField() {
        return (!is_null($this->passwordField)) ? (string) $this->passwordField : null;
    }

    public function setPasswordField($passwordField) {
        $this->passwordField = (string) $passwordField;

        return $this;
    }

    public function getPasswordValue() {
        return (!is_null($this->passwordValue)) ? (string) $this->passwordValue : null;
    }

    public function setPasswordValue($passwordValue) {
        $this->passwordValue = (string) $passwordValue;

        return $this;
    }

    protected function validateIdentifierField() {
        if (is_null($this->getIdentifierField())) {
            throw new CredentialsException(
                CredentialsException::MSG_IDENTIFIER_FIELD_NOT_SET,
                CredentialsException::CODE_IDENTIFIER_FIELD_NOT_SET
            );
        }

        if (is_null($this->getIdentifierValue())) {
            throw new CredentialsException(
                CredentialsException::MSG_IDENTIFIER_VALUE_NOT_SET,
                CredentialsException::CODE_IDENTIFIER_VALUE_NOT_SET
            );
        }
    }

    protected function validatePasswordField() {
        if (is_null($this->getPasswordField())) {
            throw new CredentialsException(
                CredentialsException::MSG_PASSWORD_FIELD_NOT_SET,
                CredentialsException::CODE_PASSWORD_FIELD_NOT_SET
            );
        }

        if (is_null($this->getPasswordValue())) {
            throw new CredentialsException(
                CredentialsException::MSG_PASSWORD_VALUE_NOT_SET,
                CredentialsException::CODE_PASSWORD_VALUE_NOT_SET
            );
        }
    }
}
