<?php
/**
 * ItemsRange.php
 *
 * PHP version 5.5+
 *
 * @category  Services
 * @module    Paginator
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 * @link      https://bitbucket.org/xeeo/services
 */
namespace Xeeo\Services\Pagintor\Entity;

use \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity;

/**
 * class ItemsRange
 *
 * @category  Services
 * @module    Paginator
 * @package   Xeeo\Services\Paginator\Entity
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
class ItemsRange extends AbstractEntity
{

    /**
     * This function needs to return an Array with all the Fields that the Entity will have with the associated Rules
     *
     * @return array
     */
    public function initFields() {

        return array(
            'firstPage' => $this->field()
                ->setRequired(true)
                ->setType('integer'),
            'lastPage'  => $this->field()
                ->setRequired(true)
                ->setType('integer')
        );
    }

    /**
     * Sets the first page of the Range
     *
     * @param int $firstPage The first page of the range
     *
     * @return $this
     */
    public function setFirstPage($firstPage) {

        $this->setField('firstPage', $firstPage);

        return $this;
    }

    /**
     * Returns the first page of the Range
     *
     * @return int
     */
    public function getFirstPage() {

        return (int) $this->getField('firstPage');
    }

    /**
     * Sets the last page of the Range
     *
     * @param int $lastPage The last page of the range
     *
     * @return $this
     */
    public function setLastPage($lastPage) {

        $this->setField('lastPage', $lastPage);

        return $this;
    }

    /**
     * Returns the last page of the Range
     *
     * @return int
     */
    public function getLastPage() {

        return (int) $this->getField('lastPage');
    }
}
