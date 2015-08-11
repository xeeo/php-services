<?php
/**
 * Variables.php
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
 * trait Variables
 *
 * @category  Services
 * @module    Paginator
 * @package   Xeeo\Services\Paginator\Components
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait Variables
{

    /**
     * Returns the number of items to be displayed on the page
     *
     * @return int
     */
    public function getItemsPerPage() {

        return (int) $this->itemsPerPage;
    }

    /**
     * Returns the Current Page
     *
     * @return int
     */
    public function getCurrentPage() {

        return (int) $this->currentPage;
    }

    /**
     * Returns the Page of the Cursor
     *
     * @return int
     */
    public function getPage() {

        return (int) $this->pageCursor;
    }

    /**
     * Returns the next available Page
     *
     * @return int
     */
    public function getNextPage() {

        $nextPage = $this->currentPage + 1;

        if ($nextPage > $this->getLastPage()) {
            return (int) $this->currentPage;
        }

        return (int) $nextPage;
    }

    /**
     * Returns the previous available Page
     *
     * @return int
     */
    public function getPreviousPage() {

        $previousPage = $this->currentPage - 1;

        if (($previousPage) < 1) {
            return (int) $this->currentPage;
        }

        return (int) $previousPage;
    }

    /**
     * Returns the first available Page
     *
     * @return int
     */
    public function getFirstPage() {

        return 1;
    }

    /**
     * Returns the last available Page
     *
     * @return int
     */
    public function getLastPage() {

        return (int) $this->getNumberOfPages();
    }

    /**
     * Returns the total number of Pages
     *
     * @return int
     */
    public function getNumberOfPages() {

        return (int) $this->numberOfPages;
    }

    /**
     * Returns the total number of Results
     *
     * @return int
     */
    public function getNumberOfResults() {

        return (int) $this->numberOfResults;
    }

    /**
     * Returns the Url Pattern based on which the Pagination Url is created
     *
     * @return string
     */
    public function getUrlPattern() {

        return (string) $this->urlPattern;
    }

    /**
     * Returns an ItemRage of the current pagination display
     * This helps when you want to show something like : Results 12 to 22
     *
     * @return ItemsRange
     */
    public function getItemsRange() {

        $itemsPerPage = $this->getItemsPerPage();
        $currentPage  = $this->getCurrentPage();

        $firstPage = (($currentPage - 1) * $itemsPerPage) + 1;
        $lastPage  = $firstPage + $itemsPerPage;

        $itemsRange = new ItemsRange();
        $itemsRange->setFirstPage($firstPage);
        $itemsRange->setLastPage($lastPage);

        return $itemsRange;
    }

    /**
     * Checks if the given Page exists in the current Pagination
     *
     * @param int $page The page to check
     *
     * @return bool
     */
    public function isPageAvailable($page) {

        return in_array((int) $page, range($this->getFirstPage(), $this->getLastPage()));
    }

    /**
     * Checks if there is a Next Page in the current Pagination
     *
     * @return bool
     */
    public function isNextPageAvailable() {

        return (($this->getPage() + 1) <= $this->getLastPage());
    }

    /**
     * Checks if there is a Previous Page in the current Pagination
     *
     * @return bool
     */
    public function isPreviousPageAvailable() {

        return (($this->getPage() - 1) >= $this->getFirstPage());
    }

    /**
     * Sets a flag so that the render method returns an empty string if there is only one page
     *
     * @param bool $ignoreIfOnlyOnePage Flag to ignore paginator if only one page
     *
     * @return $this
     */
    public function ignoreIfOnlyOnePage($ignoreIfOnlyOnePage = true) {

        $this->ignoreIfOnlyOnePage = (bool) $ignoreIfOnlyOnePage;

        return $this;
    }
}