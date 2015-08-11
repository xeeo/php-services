<?php
/**
 * Group.php
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

use \Xeeo\Services\Database\Mongo\Filter,
    \Xeeo\Services\Database\FilterInterface,
    \Xeeo\Services\Database\Mongo\Exceptions\Group as GroupException;

class Group implements FilterInterface {
    /**
     * @var string
     */
    private $firstCondition;

    /**
     * @var string
     */
    private $secondCondition;

    /**
     * @var string
     */
    private $operator;

    const OPERATOR_AND = '&';
    const OPERATOR_OR  = '|';

    /**
     * Construct
     *
     * @param FilterInterface  $firstCondition  can be a Filter Entity or a Group Entity
     * @param string           $operator        operator inside the group
     * @param FilterInterface  $secondCondition can be a Filter Entity or a Group Entity
     *
     * @throws GroupException
     *
     * @return void
     */
    public function __construct(FilterInterface $firstCondition, $operator, FilterInterface $secondCondition)
    {
        if (!in_array($operator, array(self::OPERATOR_AND, self::OPERATOR_OR))) {
            throw new GroupException(
                sprintf(GroupException::MSG_WRONG_OPERATOR, implode(",", array(self::OPERATOR_AND, self::OPERATOR_OR))),
                GroupException::CODE_WRONG_OPERATOR
            );
        }

        $this->firstCondition  = $firstCondition;
        $this->operator        = $operator;
        $this->secondCondition = $secondCondition;
    }

    public static function set(FilterInterface $firstCondition, $operator, FilterInterface $secondCondition) {
        return new self($firstCondition, $operator, $secondCondition);
    }

    /**
     * Returns the statement as a string
     *
     * @return string
     */
    public function getStatement()
    {
        switch ($this->operator) {
            case (self::OPERATOR_AND) :
                return array(
                        '$and' => array(
                            $this->firstCondition->getStatement(),
                            $this->secondCondition->getStatement()
                        )
                );
                break;
            case (self::OPERATOR_OR) :
                return array(
                        '$or' => array(
                            $this->firstCondition->getStatement(),
                            $this->secondCondition->getStatement()
                        )
                );
                break;
        }
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