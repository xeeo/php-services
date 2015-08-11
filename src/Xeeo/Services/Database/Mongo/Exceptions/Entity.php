<?php
/**
 * Entity.php
 *
 * PHP version 5.5+
 *
 * @module    Database
 * @package   Xeeo\Services\Database\Mongo\Exceptions
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Database\Mongo\Exceptions;

class Entity extends \Exception {

	const MSG_ENTITY_NOT_SET  = 'Entity not set';
	const CODE_ENTITY_NOT_SET = 1;

	const MSG_ENTITY_NOT_FOUND  = 'Entity \'%s\' does not exist';
	const CODE_ENTITY_NOT_FOUND = 2;

	const MSG_ENTITY_INVALID_TYPE  = 'Entity \'%s\' does not extend \Core\Abstract\Entity';
	const CODE_ENTITY_INVALID_TYPE = 3;
}
