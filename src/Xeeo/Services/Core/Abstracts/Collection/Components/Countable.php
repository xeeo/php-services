<?php
/**
 * Countable.php
 *
 * PHP version 5.5+
 *
 * @module    Core
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
namespace Xeeo\Services\Core\Abstracts\Collection\Components;

/**
 * trait Countable
 *
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts\Collection\Components
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait Countable {

    /**
     * Returns the Number Of Items in the Collection
     *
     * @param int $mode If the optional mode parameter is set to COUNT_RECURSIVE (or 1),
     *                  count() will recursively count the array. This is particularly useful
     *                  for counting all the elements of a multidimensional array.
     *
     * @return int
     */
    final public function count($mode = COUNT_NORMAL) {
        return count($this->entities, $mode);
    }
}
