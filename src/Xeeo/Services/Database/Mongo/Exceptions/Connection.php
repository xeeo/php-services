<?php
/**
 * Connection.php
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

class Connection extends \Exception {

	const MSG_INVALID_CONNECTION_DATA_TYPE  = 'Connection can be only String or Array';
	const CODE_INVALID_CONNECTION_DATA_TYPE = 1;

	const MSG_INVALID_CONNECTION_DATA_STRUCTURE  = 'Connection of type Array must be like : {\'name\': \'connectionName\', \'url\': \'connectionString\'}';
	const CODE_INVALID_CONNECTION_DATA_STRUCTURE = 2;

	const MSG_INVALID_CONNECTION_NAME_NOT_FOUND  = 'No connection with name \'%s\' found';
	const CODE_INVALID_CONNECTION_NAME_NOT_FOUND = 3;

	const MSG_INVALID_CONNECTION_NAME_IS_TAKEN  = 'A connection with the name \'%s\' already registered';
	const CODE_INVALID_CONNECTION_NAME_IS_TAKEN = 4;

	const MSG_CONNECTION_FAILURE = 'Couldn\'t connect to URL \'%s\' because : %s';
	const CODE_CONNECTION_FAILURE = 5;
}
