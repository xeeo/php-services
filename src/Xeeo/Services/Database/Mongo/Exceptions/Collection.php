<?php
/**
 * Collection.php
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

class Collection extends \Exception {

	const MSG_COLLECTION_NOT_SET  = 'Collection not set';
	const CODE_COLLECTION_NOT_SET = 1;

	const MSG_COLLECTION_NOT_FOUND  = 'Collection \'%s\' does not exist';
	const CODE_COLLECTION_NOT_FOUND = 2;
}
