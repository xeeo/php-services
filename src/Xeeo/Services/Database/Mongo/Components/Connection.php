<?php

namespace Xeeo\Services\Database\Mongo\Components;

use \Xeeo\Services\Database\Mongo\Exceptions\Connection as ConnectionException;

/**
 * Trait Connection
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
trait Connection
{

    private static $connections = array();

    public static function getConnectionName() {

        $connectionName = isset(static::$connection) ?
            (string) static::$connection :
            self::$defaultConnectionName;

        return $connectionName;
    }

    public static function addConnection($connection) {

        switch (true) {
            case (is_string($connection)):
                self::addConnectionByString($connection);
                break;
            case (is_array($connection)):
                self::addConnectionByArray($connection);
                break;
            default :
                throw new ConnectionException(
                    ConnectionException::MSG_INVALID_CONNECTION_DATA_TYPE,
                    ConnectionException::CODE_INVALID_CONNECTION_DATA_TYPE
                );
                break;
        }
    }

    private static function addConnectionByArray($connection) {

        $isNameSet = isset($connection['name']);
        $isUriSet  = isset($connection['url']) || isset($connection['uri']);

        if (!$isNameSet || !$isUriSet) {
            throw new ConnectionException(ConnectionException::MSG_INVALID_CONNECTION_DATA_STRUCTURE, ConnectionException::CODE_INVALID_CONNECTION_DATA_STRUCTURE);
        }

        $options = array();

        if (isset($connection['options'])) {
            $options = $connection['options'];
        }

        /** updated to URI and need backward compatibility */
        if (isset($connection['uri'])) {
            $uri = $connection['uri'];
        } else {
            $uri = $connection['url'];
        }

        self::connect($connection['name'], $uri, $options);
    }

    private static function addConnectionByString($connection) {

        self::connect(self::$defaultConnectionName, $connection);
    }

    public static function getConnections() {

        return self::$connections;
    }

    public static function getConnection() {

        $connectionName = self::getConnectionName();
        $connection     = self::getConnectionByName($connectionName);

        return $connection;
    }

    public static function getConnectionByName($connectionName = null) {

        if (is_null($connectionName)) {
            $connectionName = self::$defaultConnectionName;
        } else {
            $connectionName = strtolower((string) $connectionName);
        }

        if (false === self::connectionExists($connectionName)) {

            throw new ConnectionException(
                sprintf(ConnectionException::MSG_INVALID_CONNECTION_NAME_NOT_FOUND, $connectionName),
                ConnectionException::CODE_INVALID_CONNECTION_NAME_NOT_FOUND
            );
        }

        return self::$connections[$connectionName];
    }

    private static function connectionExists($connectionName) {

        $connections    = self::getConnections();
        $connectionName = strtolower($connectionName);

        return isset($connections[$connectionName]);
    }

    private static function blockDuplicateConnections($connectionName) {

        $connectionName = strtolower((string) $connectionName);

        if (self::connectionExists($connectionName)) {
            throw new ConnectionException(sprintf(
                    ConnectionException::MSG_INVALID_CONNECTION_NAME_IS_TAKEN,
                    $connectionName
                ), ConnectionException::CODE_INVALID_CONNECTION_NAME_IS_TAKEN);
        }
    }

    private static function getDatabaseName($connectionUrl) {

        preg_match("/\/([^\/]+)$/", $connectionUrl, $matches);

        return (isset($matches[1])) ? $matches[1] : '';
    }

    public static function getDatabase() {

        $connection = self::getConnection();
        $database   = $connection->instance->{$connection->database};

        return $database;
    }

    private static function connect($connectionName, $connectionUrl, $connectionOptions = array()) {

        $connectionName = strtolower((string) $connectionName);
        $connectionUrl  = (string) $connectionUrl;

        self::blockDuplicateConnections($connectionName);

        try {

            $connection           = new \stdClass();
            $connection->database = self::getDatabaseName($connectionUrl);
            $connection->instance = new \MongoClient($connectionUrl, $connectionOptions);

            self::$connections[$connectionName] = $connection;
        } catch (\MongoConnectionException $e) {
            throw new ConnectionException(sprintf(
                ConnectionException::MSG_CONNECTION_FAILURE,
                $connectionUrl,
                'Invalid URL'
            ), ConnectionException::CODE_CONNECTION_FAILURE);
        } catch (\Exception $e) {
            throw new ConnectionException(sprintf(
                    ConnectionException::MSG_CONNECTION_FAILURE,
                    $connectionUrl,
                    $e->getMessage()
                ), ConnectionException::CODE_CONNECTION_FAILURE);
        }
    }
}
