<?php

use \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity;

class UserPersonalInfo extends AbstractEntity
{

    public function initFields() {

        return array(
            'address' => $this->field(),
            'jobs'    => $this->field(),
        );
    }
}