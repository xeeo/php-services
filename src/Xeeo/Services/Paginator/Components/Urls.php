<?php
/**
 * Urls.php
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
namespace Xeeo\Services\Paginator\Components;

/**
 * trait Urls
 *
 * @category  Services
 * @module    Paginator
 * @package   Xeeo\Services\Paginator\Components
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait Urls
{

    /**
     * Returns the Url as string for a given Page based on the Url Pattern
     *
     * @param int $page The page number you want the Url for
     *
     * @return string
     */
    public function getUrlForPage($page) {

        $page = (int) $page;

        return str_replace(self::PAGE_NUMBER_PLACEHOLDER, $page, $this->getUrlPattern());
    }

    /**
     * Returns the Url for the Current Page
     * The Url is created based on the Url Pattern
     *
     *
     * @return string
     */
    public function getCurrentPageUrl() {

        return $this->getUrlForPage($this->getCurrentPage());
    }

    /**
     * Returns the Url for the Page of the Cursor
     *
     * @return int
     */
    public function getPageUrl() {

        return $this->getUrlForPage($this->getPage());
    }

    /**
     * Returns the Url for the next available Page
     * The Url is created based on the Url Pattern
     *
     * @return string
     */
    public function getNextPageUrl() {

        return $this->getUrlForPage($this->getNextPage());
    }

    /**
     * Returns the Url for the previous available Page
     * The Url is created based on the Url Pattern
     *
     * @return string
     */
    public function getPreviousPageUrl() {

        return $this->getUrlForPage($this->getPreviousPage());
    }

    /**
     * Returns the Url for the first available Page
     * The Url is created based on the Url Pattern
     *
     * @return string
     */
    public function getFirstPageUrl() {

        return $this->getUrlForPage($this->getFirstPage());
    }

    /**
     * Returns the Url for the last available Page
     * The Url is created based on the Url Pattern
     *
     * @return string
     */
    public function getLastPageUrl() {

        return $this->getUrlForPage($this->getLastPage());
    }
}