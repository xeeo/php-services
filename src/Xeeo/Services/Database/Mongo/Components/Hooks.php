<?php
/**
 * Hooks.php
 *
 * PHP version 5.5+
 *
 * @module    Database
 * @package   Xeeo\Services\Database\Mongo\Components
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Database\Mongo\Components;

use \Xeeo\Services\Core\Abstracts\Entity as AbstractEntity,
    \Xeeo\Services\Database\Mongo\Exceptions\Entity as EntityException;

trait Hooks {

    private static function callPreSaveHook(AbstractEntity $entity) {
        $entity->preSaveHook();

        foreach ($entity->getData() as $fieldInstance) {
            if ($fieldInstance instanceof AbstractEntity) {
                self::callPreSaveHook($fieldInstance);
            }
        }
    }

    private static function callPostSaveHook(AbstractEntity $entity) {
        $entity->postSaveHook();

        foreach ($entity->getData() as $fieldInstance) {
            if ($fieldInstance instanceof AbstractEntity) {
                self::callPostSaveHook($fieldInstance);
            }
        }
    }

}
