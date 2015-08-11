<?php
/**
 * PaginatorInterface.php
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
namespace Xeeo\Services\Paginator;

use \Xeeo\Services\Core\Abstracts\CollectionInterface;

/**
 * interface CollectionInterface
 *
 * @category  Services
 * @module    Paginator
 * @package   Xeeo\Services\Paginator
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
interface PaginatorInterface
{

    /**
     * Sets the number of items to be displayed on the page
     *
     * @param int $itemsPerPage The number of items to be displayed on the page
     *
     * @return $this
     */
    public function setItemsPerPage($itemsPerPage);

    /**
     * Sets the current Page
     *
     * @param int $currentPage The current Page
     *
     * @return $this
     */
    public function setCurrentPage($currentPage);

    /**
     * Sets the Collection that gets to be paginated
     *
     * @param CollectionInterface $collection The collection to be paginated
     *
     * @return $this
     */
    public function setCollection(CollectionInterface $collection);

    /**
     * Sets the Html Template that gets to be rendered
     *
     * @param string $pathToHtmlTemplateFile The Html Template that gets to be rendered
     *
     * @return $this
     *
     * @throws PaginatorException
     */
    public function setHtmlTemplate($pathToHtmlTemplateFile);

    /**
     * Sets the Url Pattern based on which the Pagination Url is created
     *
     * @param string $urlPattern The Url Pattern based on which the Pagination Url are created
     *
     * @return $this
     *
     * @throws PaginatorException
     */
    public function setUrlPattern($urlPattern);

    /**
     * Returns the Rendered string based on the Template
     *
     * @return string
     *
     * @throws PaginatorException
     */
    public function render();

    /**
     * Resets Current Page cursor to First available Page
     *
     * @return void
     */
    public function reset();

    /**
     * Returns the Url as string for a given Page based on the Url Pattern
     *
     * @param int $page The page number you want the Url for
     *
     * @return string
     */
    public function getUrlForPage($page);

    /**
     * Returns the Url for the Current Page
     * The Url is created based on the Url Pattern
     *
     *
     * @return string
     */
    public function getCurrentPageUrl();

    /**
     * Returns the Url for the Page of the Cursor
     *
     * @return int
     */
    public function getPageUrl();

    /**
     * Increments the Page Cursor and returns the value
     * ! Important: This method changes the Page cursor
     *
     * @return int
     */
    public function nextPage();

    /**
     * Decreases the Page Cursor and returns the value
     * ! Important: This method changes the Page cursor
     *
     * @return int
     */
    public function previousPage();

    /**
     * Returns the Url for the Next Page
     * ! Important: This method changed the Current Page
     * The Url is created based on the Url Pattern
     *
     * @return string
     */
    public function getNextPageUrl();

    /**
     * Returns the Url for the Previous Page
     * ! Important: This method changed the Current Page
     * The Url is created based on the Url Pattern
     *
     * @return string
     */
    public function getPreviousPageUrl();

    /**
     * Returns the Url for the First available Page
     * The Url is created based on the Url Pattern
     *
     * @return string
     */
    public function getFirstPageUrl();

    /**
     * Returns the Url for the Last available Page
     * The Url is created based on the Url Pattern
     *
     * @return string
     */
    public function getLastPageUrl();

    /**
     * Returns the number of items to be displayed on the page
     *
     * @return int
     */
    public function getItemsPerPage();

    /**
     * Returns the Current Page
     *
     * @return int
     */
    public function getCurrentPage();

    /**
     * Returns the Page of the Cursor
     *
     * @return int
     */
    public function getPage();

    /**
     * Returns the next available Page
     *
     * @return int
     */
    public function getNextPage();

    /**
     * Returns the previous available Page
     * ! Important: This method changes the Current Page cursor
     *
     * @return int
     */
    public function getPreviousPage();

    /**
     * Returns the first available Page
     *
     * @return int
     */
    public function getFirstPage();

    /**
     * Returns the last available Page
     *
     * @return int
     */
    public function getLastPage();

    /**
     * Returns the total number of pages
     *
     * @return int
     */
    public function getNumberOfPages();

    /**
     * Returns the total number of Results
     *
     * @return int
     */
    public function getNumberOfResults();

    /**
     * Returns the Url Pattern based on which the Pagination Url is created
     *
     * @return string
     */
    public function getUrlPattern();

    /**
     * Returns an ItemRage of the current pagination display
     * This helps when you want to show something like : Results 12 to 22
     *
     * @return ItemsRange
     */
    public function getItemsRange();

    /**
     * Checks if the given Page exists in the current Pagination
     *
     * @param int $page The page to check
     *
     * @return bool
     */
    public function isPageAvailable($page);

    /**
     * Checks if there is a Next Page in the current Pagination
     *
     * @return bool
     */
    public function isNextPageAvailable();

    /**
     * Checks if there is a Previous Page in the current Pagination
     *
     * @return bool
     */
    public function isPreviousPageAvailable();

    /**
     * Sets a flag so that the render method returns an empty string if there is only one page
     *
     * @param bool $ignoreIfOnlyOnePage Flag to ignore paginator if only one page
     *
     * @return $this
     */
    public function ignoreIfOnlyOnePage($ignoreIfOnlyOnePage = true);
}