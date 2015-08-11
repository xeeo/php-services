<?php
/**
 * Collection.php
 *
 * PHP version 5.5+
 *
 * @module    Database
 * @package   Xeeo\Services\Database\Mongo\Components
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Database\Mongo\Components;

use \Xeeo\Services\Database\Mongo\Exceptions\Collection as CollectionException;

trait Collection {

	public static function getCollectionName() {
		self::validateCollectionIsSet();

		return static::$collection;
	}

	private static function validateCollectionIsSet() {
		if ((false === isset(static::$collection)) || (is_null(static::$collection))) {
			throw new CollectionException(
				CollectionException::MSG_COLLECTION_NOT_SET,
				CollectionException::CODE_COLLECTION_NOT_SET
			);
		}
	}

	public static function getCollection() {

        $database           = self::getDatabase();
        $collection         = self::getCollectionName();
        $collectionInstance = $database->{$collection};

        return $collectionInstance;
    }
}
