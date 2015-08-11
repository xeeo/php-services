<?php
/**
 * PaginatorApi.php
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

use \Xeeo\Services\Core\Patterns\Singleton as SingletonPattern,
    \Xeeo\Services\Core\Patterns\SingletonInterface as SingletonPatternInterface,
    \Xeeo\Services\Paginator\Exceptions\Paginator as PaginatorException,
    \Xeeo\Services\Paginator\PaginatorInterface,
    \Xeeo\Services\Core\Abstracts\CollectionInterface,
    \Xeeo\Services\Pagintor\Entity\ItemsRange;

/**
 * class PaginatorApi
 *
 * @category  Services
 * @module    Paginator
 * @package   Xeeo\Services\Authenticate
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
class PaginatorApi implements PaginatorInterface, SingletonPatternInterface
{
    use SingletonPattern,
        Components\Config,
        Components\Validators,
        Components\Variables,
        Components\Urls;

    const PAGE_NUMBER_PLACEHOLDER = "{#PAGE}";

    /**
     * @var int
     */
    private $currentPage = 1;

    /**
     * @var int
     */
    private $pageCursor = 1;

    /**
     * @var int
     */
    private $itemsPerPage = 10;

    /**
     * @var int
     */
    private $numberOfPages = 1;

    /**
     * @var int
     */
    private $numberOfResults = 0;

    /**
     * @var CollectionInterface
     */
    private $collection = null;

    /**
     * @var string
     */
    private $urlPattern = '';

    /**
     * @var string
     */
    private $htmlTemplateFile = '';

    /**
     * @var bool
     */
    private $ignoreIfOnlyOnePage = false;

    /**
     * This function is called when a new Instance of this object is created
     *
     * @param array|null $config The configuration parameters
     *
     * @return void
     */
    public function init($config = null) {
        $this->initializeConfig($config);
    }

    /**
     * Returns the Rendered string based on the Template
     *
     * @return string
     *
     * @throws PaginatorException
     */
    public function render() {

        $output = '';

        $this->checkTemplateFileExistence($this->htmlTemplateFile);
        $this->checkCollectionExistence($this->collection);
        $this->calculateNumberOfPages();

        if (($this->getNumberOfPages() > 1) || (false === $this->ignoreIfOnlyOnePage)) {
            ob_start();
            require($this->htmlTemplateFile);
            $output = ob_get_contents();
            ob_end_clean();
        }

        echo $output;
    }

    /**
     * Resets Current Page cursor to First available Page
     *
     * @return void
     */
    public function reset() {
        $this->pageCursor = $this->getFirstPage();
    }

    /**
     * Increments the Page Cursor and returns the value
     * ! Important: This method changes the Page cursor
     *
     * @return int
     */
    public function nextPage() {

        $nextPage = $this->pageCursor + 1;

        if ($nextPage > $this->getLastPage()) {
            return (int) $this->pageCursor;
        }

        $this->pageCursor = (int) $nextPage;

        return $this->pageCursor;
    }

    /**
     * Decreases the Page Cursor and returns the value
     * ! Important: This method changes the Page cursor
     *
     * @return int
     */
    public function previousPage() {

        $previousPage = $this->pageCursor - 1;

        if (($previousPage) < 1) {
            return (int) $this->pageCursor;
        }

        $this->pageCursor = (int) $previousPage;

        return $this->pageCursor;
    }


    /**
     * Calculates the total number of pages
     *
     * @return void
     */
    private function calculateNumberOfPages() {

        $numberOfResults = $this->getNumberOfResults();
        $numberOfPages   = ceil($numberOfResults / $this->getItemsPerPage());

        if ($numberOfPages === 0) {
            $numberOfPages = 1;
        }

        $this->numberOfPages = $numberOfPages;
    }
}
