<?php
/**
 * Iterator.php
 *
 * PHP version 5.5+
 *
 * @category  Services
 * @module    Core
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 * @link      https://bitbucket.org/xeeo/services
 */
namespace Xeeo\Services\Core\Abstracts\Entity\Components;

/**
 * trait Iterator
 *
 * @category  Services
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts\Entity\Components
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait Iterator
{

    final public function rewind() {

        reset($this->fields);
    }

    final public function current() {

        current($this->fields);
    }

    final public function key() {

        return key($this->fields);
    }

    final public function next() {

        return next($this->fields);
    }

    final public function valid() {

        return key($this->fields) !== null;
    }
}
