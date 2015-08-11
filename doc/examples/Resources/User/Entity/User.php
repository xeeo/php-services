<?php

require __DIR__ . '/User/PersonalInfo.php';
require __DIR__ . '/User/Credentials.php';
require __DIR__ . '/User/Address.php';

use \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity;

class UserEntity extends AbstractEntity
{
    public function initFields() {
        return array(
            '_id'          => $this->field()
                ->setIgnore(true),
            
            'parentId'     => $this->field()
                ->setReference(new UserMapper())
                ->setIgnore(true),

            'name'         => $this->field()
                ->setIgnore(true),
            'credentials' => $this->field()
                ->setRequired(true)
                ->setType('UserCredentials'),
            'personalInfo' => $this->field()
                ->setRequired(true)
                ->setType('UserPersonalInfo'),
            'addresses' => $this->field()
                ->setRequired(true)
                ->setType('collection'),
            'status' => $this->field()
                ->setRequired(true)
        );
    }
}
