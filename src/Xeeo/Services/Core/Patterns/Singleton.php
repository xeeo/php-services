<?php
/**
 * Singleton.php
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

trait Singleton {

	 /**
     * @var array
     */
    private static $instance = null;

    /**
     * Block Construct call
     */
    protected function __construct() {}

    /**
     * Block Clone call
     */
    protected function __clone() {}

    /**
     * Block Wakeup call
     */
    protected function __wakeup() {}

    /**
     * Block Sleep call
     */
    protected function __sleep() {}

	/**
     * returns an instance of the called object
     *
     * @return object
     */
    public static function getInstance($config = null)
    {
        if (is_null(self::$instance)) {
            self::getNewInstance($config);
        } elseif (!is_null($config)) {
            throw new \Exception('
                There is already an initial Instance of this object with a given Config.
                To pass a new config you\'ll need to call getNewInstance and automatically reset your old one.
            ');
        }

        return self::$instance;
    }

    /**
     * returns an instance of the called object
     *
     * @return object
     */
    public static function getNewInstance($config = null)
    {
		self::$instance = new static;

        self::$instance->init($config);

        return self::$instance;
    }

    private function initializeConfig($config) {
        if (is_null($config)) {
            return;
        }

        if (empty($config)) {
            throw new \Exception('You can\'t initialize an empty config');
        }

        foreach ($config as $configItem => $value) {
            $configItem = ucfirst($configItem);

            try {
                $method = "set{$configItem}";
                $this->{$method}($value);
            } catch(\Exception $e) {
                throw new \Exception("Failed setting Config Item '{$configItem}' because : {$e->getMessage()} ");
            }
        }
    }
}
