<?php
/**
 * ArrayAccess.php
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
 * trait ArrayAccess
 *
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts\Collection\Components
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait ArrayAccess {

    final public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->entities[] = $value;
        } else {
            $this->entities[$offset] = $value;
        }
    }

    final public function offsetExists($offset) {
        return isset($this->entities[$offset]);
    }

    final public function offsetUnset($offset) {
        unset($this->entities[$offset]);
    }

    final public function offsetGet($offset) {
        return isset($this->entities[$offset]) ? $this->entities[$offset] : null;
    }

}
