<?php
/**
 * Config.php
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

use \Xeeo\Services\Core\Abstracts\CollectionInterface,
    \Xeeo\Services\Paginator\Exceptions\Paginator as PaginatorException;

/**
 * trait Config
 *
 * @category  Services
 * @module    Paginator
 * @package   Xeeo\Services\Paginator\Components
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait Config
{

    /**
     * Sets the number of items to be displayed on the page
     *
     * @param int $itemsPerPage The number of items to be displayed on the page
     *
     * @return $this
     */
    public function setItemsPerPage($itemsPerPage) {

        $this->itemsPerPage = (int) $itemsPerPage;
        $this->calculateNumberOfPages();

        return $this;
    }

    /**
     * Sets the current Page
     *
     * @param int $currentPage The current Page
     *
     * @return $this
     */
    public function setCurrentPage($currentPage) {

        $this->currentPage = (int) $currentPage;
        $this->pageCursor  = $this->currentPage;

        $this->calculateNumberOfPages();

        return $this;
    }

    /**
     * Sets the Collection that gets to be paginated
     *
     * @param CollectionInterface $collection The collection to be paginated
     *
     * @return $this
     *
     */
    public function setCollection(CollectionInterface $collection) {

        $this->collection = $collection;
        $this->setNumberOfResults($collection->countIgnoringOffsetAndLimit());

        return $this;
    }

    /**
     * Sets the Html Template that gets to be rendered
     *
     * @param string $pathToHtmlTemplateFile The Html Template that gets to be rendered
     *
     * @return $this
     *
     * @throws PaginatorException
     */
    public function setHtmlTemplate($pathToHtmlTemplateFile) {

        $this->checkTemplateFileExistence($pathToHtmlTemplateFile);
        $this->htmlTemplateFile = (string) $pathToHtmlTemplateFile;

        return $this;
    }

    /**
     * Sets the Url Pattern based on which the Pagination Url is created
     *
     * @param string $urlPattern The Url Pattern based on which the Pagination Url are created
     *
     * @return $this
     *
     * @throws PaginatorException
     */
    public function setUrlPattern($urlPattern) {

        $this->validateUrlPattern($urlPattern);
        $this->urlPattern = (string) $urlPattern;

        return $this;
    }

    /**
     * Sets the total number of Results
     *
     * @param int $numberOfResults Total number of Results
     *
     * @return $this
     */
    private function setNumberOfResults($numberOfResults) {

        $this->numberOfResults = (int) $numberOfResults;
        $this->calculateNumberOfPages();

        return $this;
    }
}
