<?php

use \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity;

class UserCredentials extends AbstractEntity
{

    public function initFields() {

        return array(
            'email'    => $this->field()->setRequired(true),
            'password' => $this->field()->setRequired(true)
        );
    }
}