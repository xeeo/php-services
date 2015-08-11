<?php
/**
 * Reference.php
 *
 * PHP version 5.5+
 *
 * @category  Services
 * @module    Database
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 * @link      https://bitbucket.org/xeeo/services
 */
namespace Xeeo\Services\Database\Mongo\Components;

/**
 * trait Reference
 *
 * @category  Services
 * @module    Database
 * @package   Xeeo\Services\Database\Mongo\Components
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait Reference
{

	public static function createReference($entity) {

        $database       = static::getDatabase();
        $collectionName = static::$collection;
        
       	$reference = $database->createDBRef($collectionName, $entity->toArray());

       	return $reference;
	}

	public static function getReferencedEntity($reference) {

        $database      = static::getDatabase();
        $rawEntityData = $database->getDBRef($reference);

		$entity = self::createObject($rawEntityData);

		return $entity;
	}

	public static function isReference($value) {
		return (\MongoDBRef::isRef($value));
	}

}