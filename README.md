Xeeo\Services
=======


## Installation

Xeeo\Services uses Composer, please checkout the [composer website](http://getcomposer.org) for more information.

You will need to add this to your composer.json and be part of the AWESOME team of NewHaircut

```json
{
	"repositories": [
        {
            "type" : "git",
            "url"  : "https://github.com/xeeo/php-services.git"
        }
    ],
    "require": {
        "xeeo/services": "dev-master"
    }
}
```

> Xeeo\Services follows the PSR-0 convention names for its classes, which means you can easily integrate `xeeo-services` classes loading in your own autoloader.

## Getting Started

```php
<?php

// Include dependencies installed with composer
require 'vendor/autoload.php';

use \Xeeo\Services\Database\Mongo\Mapper as MongoMapper,
    \Xeeo\Services\User\Mapper\User as UserMapper,
    \Xeeo\Services\User\Entity\User,
    \Xeeo\Services\User\Entity\User\PersonalInfo;

MongoMapper::addConnection(array(
                                'name' => 'connectionName',
                                'url'  => 'mongodb://localhost:27017/databaseName'
                           ));

$newUser = new User();
$newUser->setField('_id', new \MongoId());
$newUser->setField('name', 'A1i');
$newUser->setField('email', 'AdrianMeresescu@gmail.com');

$personalInfo = new PersonalInfo();
$personalInfo->setField('address', 'some fake address');
$personalInfo->setField('jobs', array('developer', 'qa'));


$newUser->setField('personalInfo', $personalInfo);

$return = UserMapper::save($newUser);

$insertedId = $return['upserted']->{'$id'};

$user = UserMapper::get($insertedId);

print_r($user);
```

Enjoy.
