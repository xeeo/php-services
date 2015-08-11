<?php

require __DIR__ . '/../Entity/User.php';

use \Xeeo\Services\Database\Mongo\Mapper as Mapper;

final class UserMapper extends Mapper
{

    protected static $connection = 'connectionName'; // default;
    protected static $collection = 'collectionName';
    protected static $entity = 'UserEntity';
}
