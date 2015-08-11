<?php
require '../../../vendor/autoload.php';

require '../Resources/User/Mapper/User.php';

use \Xeeo\Services\Database\Mongo\Mapper as MongoMapper,
    \Xeeo\Services\Authenticate\AuthenticateApi,
    \Xeeo\Services\Database\Mongo\Filter;

MongoMapper::addConnection(array(
                                'name' => 'connectionName',
                                'url'  => 'mongodb://localhost:27017/databaseName'
                           ));

$config = array(
    'passwordField'   => 'credentials.password',
    'identifierField' => 'credentials.email',
    'mapper'          => 'UserMapper',
    'hashSalt'        => 'some random text',
    'hashCost'        => 10
);

/**
 * @var AuthenticateApi $authApi
 */
$authApi = AuthenticateApi::getInstance($config);

try {

    $criteria = Filter::set('status', Filter::EQUAL, 'active');

    $login = $authApi->setIdentifierValue('geana.raul@gmail.com')
        ->setPasswordValue('password')
        ->setConstraints($criteria)
        ->authenticate();

    var_dump($login);

} catch (\Exception $e) {
    print_r($e->getMessage());
}
