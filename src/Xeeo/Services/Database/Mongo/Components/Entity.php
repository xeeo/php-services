<?php
/**
 * Entity.php
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

use \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity,
	\Xeeo\Services\Database\Mongo\Exceptions\Entity as EntityException;

trait Entity {

	public static function getEntity() {
		self::validateEntityIsSet();
		self::validateEntityExistence();
		$entityInstance = new static::$entity();
		self::validateEntityType($entityInstance);

		return $entityInstance;
	}

	private static function validateEntityIsSet() {
		if ((false === isset(static::$entity)) || (is_null(static::$entity))) {
			throw new EntityException(
				EntityException::MSG_ENTITY_NOT_SET,
				EntityException::CODE_ENTITY_NOT_SET
			);
		}
	}

	private static function validateEntityExistence() {
		try {
			return class_exists(static::$entity);
		} catch (\Exception $e) {
			throw new EntityException(
				sprintf(EntityException::MSG_ENTITY_NOT_FOUND, static::$entity),
				EntityException::CODE_ENTITY_NOT_FOUND
			);
		}
	}

	private static function validateEntityType($entity) {
		if (false === ($entity instanceof AbstractEntity)) {
			throw new EntityException(
				sprintf(EntityException::MSG_ENTITY_INVALID_TYPE, $entity),
				EntityException::CODE_ENTITY_INVALID_TYPE
			);
		}
	}
}
