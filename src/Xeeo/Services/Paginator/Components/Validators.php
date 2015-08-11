<?php
/**
 * Validators.php
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
 * trait Validators
 *
 * @category  Services
 * @module    Paginator
 * @package   Xeeo\Services\Paginator\Components
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait Validators
{

    /**
     * Checks that the Template file exists
     *
     * @param string $pathToHtmlTemplateFile The path to the template file
     *
     * @return void
     *
     * @throws PaginatorException
     */
    private function checkTemplateFileExistence($pathToHtmlTemplateFile) {

        $pathToHtmlTemplateFile = (string) $pathToHtmlTemplateFile;

        if (!file_exists($pathToHtmlTemplateFile)) {
            throw new PaginatorException(
                sprintf(PaginatorException::MSG_TEMPLATE_NOT_FOUND, $pathToHtmlTemplateFile),
                PaginatorException::CODE_TEMPLATE_NOT_FOUND
            );
        }
    }

    /**
     * Checks that the Collection we want to paginate exists
     *
     * @param CollectionInterface $collection The Collection we want to paginate
     *
     * @return void
     *
     * @throws PaginatorException
     */
    private function checkCollectionExistence($collection) {

        if (empty($collection)) {
            throw new PaginatorException(
                PaginatorException::MSG_COLLECTION_NOT_SET,
                PaginatorException::CODE_COLLECTION_NOT_SET
            );
        }
    }

    /**
     * Checks that the UrlPattern has the right placeholder
     *
     * @param string $urlPattern The pattern based on which the url will be created
     *
     * @return void
     *
     * @throws PaginatorException
     */
    private function validateUrlPattern($urlPattern) {

        $urlPattern = (string) $urlPattern;

        if (strpos($urlPattern, self::PAGE_NUMBER_PLACEHOLDER) === false) {
            throw new PaginatorException(
                sprintf(PaginatorException::MSG_WRONG_URL_PATTERN, self::PAGE_NUMBER_PLACEHOLDER),
                PaginatorException::CODE_WRONG_URL_PATTERN
            );
        }
    }



}