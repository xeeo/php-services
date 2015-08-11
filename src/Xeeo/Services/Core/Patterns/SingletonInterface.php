<?php
/**
 * SingletonInterface.php
 *
 * PHP version 5.5+
 *
 * @module    Core
 * @package   Xeeo\Services\Core\Patterns
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Core\Patterns;

interface SingletonInterface {

	public function init($config = null);

	/**
	 * returns an instance of the called object
	 *
	 * @return object
	 */
	public static function getInstance($config = null);


	/**
	 * returns an instance of the called object
	 *
	 * @return object
	 */
	public static function getNewInstance($config = null);

}
