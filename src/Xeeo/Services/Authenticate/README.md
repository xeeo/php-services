The Authenticate Api
===

The Api fas following functionality

## Method list

```php

    public function init($config = null);

    public function authenticate();

    public function getHashAlgorithm();

    public function setHashAlgorithm($hashAlgorithm);

    public function getHashSalt();

    public function setHashSalt($hashSalt);

    public function getHashCost();

    public function setHashCost($hashCost);

    public function hashPassword($plainPassword);

    public function generatePassword($length = 10);

    public function validatePassword($plainPassword, $hashedPassword);

    public function getIdentifierField();

    public function setIdentifierField($identifierField);

    public function getIdentifierValue();

    public function setIdentifierValue($identifierValue);

    public function getPasswordField();

    public function setPasswordField($passwordField);

    public function getPasswordValue();

    public function setPasswordValue($passwordValue);

    public function getMapper();

    public function setMapper($mapper);

```