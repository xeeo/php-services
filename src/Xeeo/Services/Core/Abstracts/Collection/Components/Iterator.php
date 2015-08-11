<?php
/**
 * Iterator.php
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
 * trait Iterator
 *
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts\Collection\Components
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait Iterator {

    final public function rewind() {
        reset($this->entities);
    }

    final public function current() {
        return current($this->entities);
    }

    final public function key() {
        return key($this->entities);
    }

    final public function next() {
        return next($this->entities);
    }

    final public function valid() {
        return key($this->entities) !== null;
    }

}
