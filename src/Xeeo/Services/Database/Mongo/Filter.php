<?php
/**
 * Filter.php
 *
 * PHP version 5.5+
 *
 * @module    Database
 * @package   Xeeo\Services\Database\Mongo
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Database\Mongo;

use \Xeeo\Services\Database\FilterInterface;

class Filter implements FilterInterface {

    const EQUAL     = '=';
    const NOT_EQUAL = '!=';

    const LESS          = '<';
    const LESS_OR_EQUAL = '<=';

    const GREATER          = '>';
    const GREATER_OR_EQUAL = '>=';

    const LIKE     = 'like';
    const NOT_LIKE = '!like';

    const IN     = 'in';
    const NOT_IN = '!in';

    const REGEXP = 'regex';

    const ELEMENTMATCH = 'elemmatch';

    const EXISTS = 'exists';

    const VALUE_NULL = 'null';

    private $key          = null;
    private $comparator   = null;
    private $value        = null;

    public static function set($key, $comparator, $value) {
        return new self($key, $comparator, $value);
    }

    /**
     * Constructor - creates a filter entity with given structure
     *
     * @param string $key        the field name for search filter
     * @param string $comparator comparator between key and value
     * @param string $value      the value witch to compare
     */
    public function __construct($key, $comparator, $value)
    {
        $this->key        = (string) $key;
        $this->comparator = $comparator;
        $this->value      = $value;
    }

    /**
     * Returns the statement as array
     *
     * @return array
     */
    public function getAssociation()
    {
        $expression = array();

        switch ($this->comparator) {

            case (self::EQUAL)  :
                $expression = array($this->key => $this->value);
                break;
            case (self::REGEXP) :
                $expression = array($this->key => new \MongoRegex($this->value));
                break;
            case (self::ELEMENTMATCH) :
                $expression = array($this->key => array('$elemMatch' => $this->value));
                break;
            case (self::ELEMENTMATCH) :
                $expression = array($this->key => array('$exists' => (bool) $this->value));
                break;
            case (self::LIKE) :
                $expression = array($this->key => new \MongoRegex("/" . $this->value . "/"));
                break;
            case (self::NOT_LIKE)  :
                $expression = array($this->key => array('$ne' => new \MongoRegex("/" . $this->value . "/")));
                break;
            case (self::NOT_EQUAL) :
                $expression = array($this->key => array('$ne' => $this->value));
                break;
            case (self::LESS) :
                $expression = array($this->key => array('$lt' => $this->value));
                break;
            case (self::LESS_OR_EQUAL) :
                $expression = array($this->key => array('$lte' => $this->value));
                break;
            case (self::GREATER) :
                $expression = array($this->key => array('$gt' => $this->value));
                break;
            case (self::GREATER_OR_EQUAL) :
                $expression = array($this->key => array('$gte' => $this->value));
                break;
            case (self::IN) :
                $expression = array($this->key => array('$in' => $this->value));
                break;
            case (self::NOT_IN) :
                $expression = array($this->key => array('$nin' => $this->value));
                break;
        }

        return $expression;
    }

    public function getStatement() {
        return $this->getAssociation();
    }

    /**
     * @return string
     */
    public function __toString() {
        $queryString = json_encode($this->getStatement());
        $queryString = $this->treatSpecialCases($queryString);

        return $queryString;
    }

    private function treatSpecialCases($queryString) {
        $queryString = str_replace('regex', '$regex', $queryString);
        $queryString = str_replace('flags', '$options', $queryString);

        return $queryString;
    }

}
