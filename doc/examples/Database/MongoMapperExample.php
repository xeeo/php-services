<?php
require '../../../vendor/autoload.php';

require '../Resources/User/Mapper/User.php';

use \Xeeo\Services\Database\Mongo\Mapper as MongoMapper,
    \Xeeo\Services\Authenticate\AuthenticateApi;

$authApi = AuthenticateApi::getInstance();

MongoMapper::addConnection(array(
                                'name' => 'connectionName',
                                'url'  => 'mongodb://localhost:27017/databaseName'
                           ));

$user = new \UserEntity();
$user->setField('name', 'Raul Geana');
$user->setField('status', 'pending');

$addresses = new \Xeeo\Services\Core\Abstracts\Collection();

$address = new \UserAddress();
$address->setField('city', 'Timisoara');
$address->setField('str', 'Borsec');

$addresses[] = $address;

$address = new \UserAddress();
$address->setField('city', 'New York');
$address->setField('str', 'Times Square');

$addresses[] = $address;

$address = new \UserAddress();
$address->setField('city', 'Munchen');
$address->setField('str', 'Leopold Strasse');

$addresses[] = $address;

$addresses->removeEntities(function($entity) {
	return ($entity->getField('city') == 'Timisoara');
});

$user->setField('addresses', $addresses);

$personalInfo = new \UserPersonalInfo();
$personalInfo->setField('address', 'some fake address');
$personalInfo->setField('jobs', array('developer', 'cto'));

$credentials = new \UserCredentials();
$credentials->setField('email', 'geana.raul@gmail.com');
$credentials->setField('password', $authApi->hashPassword('password'));

$user->setField('personalInfo', $personalInfo);
$user->setField('credentials', $credentials);

$newUser = $user;

$return = \UserMapper::save($user);

$newUser->setField('parentId', $return);
$newUser->setField('_id', null);

$newReturn = \UserMapper::save($newUser); 

$foundUser = \UserMapper::get($newReturn->getField('_id'));

print_r($foundUser->toArray());
