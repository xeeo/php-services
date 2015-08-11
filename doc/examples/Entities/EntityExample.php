<?php
require '../../../vendor/autoload.php';

require '../Resources/User/Mapper/User.php';

$user = new \UserEntity();

$userArray = array(
    'name'         => "Raul",
    'personalInfo' => array(
        'address' => "StartupHub",
        'jobs'    => "Trainer"
	),
    'status'       => "active"
);

$user->populateFromArray($userArray);

var_dump($user);