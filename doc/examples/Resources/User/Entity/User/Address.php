<?php

use \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity;

class UserAddress extends AbstractEntity
{

    public function initFields() {

        return array(
            'city' => $this->field(),
            'str'  => $this->field(),
        );
    }
}