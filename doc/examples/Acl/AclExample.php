<?php

require '../../../vendor/autoload.php';

use \Xeeo\Services\Acl\AclApi;

$rules = array(

    'manage-assignee' => array(
        'add-assignee' => true,
        'edit-assignee' => true
    ),

    'manage-location' => array(
        'add-location' => true,
        'edit-location' => true
    ),

    'manage-employee' => array(
        'add-employee' => true,
        'edit-employee' => true
    )
);

$aclApi = AclApi::getInstance();
$aclApi->throwExceptionForUndefinedResouce(false)
       ->setDefaultValue(false)
       ->trueOverwrites(true)
       ->setRules($rules);


$userPermissions = array('manage-assignee', 'manage-employee');

var_dump($aclApi->canAccess('edit-assignee', $userPermissions));
