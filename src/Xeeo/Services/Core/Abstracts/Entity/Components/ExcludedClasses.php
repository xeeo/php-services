<?php
/**
 * ExcludedClasses.php
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
 * trait ExcludedClasses
 *
 * @category  Services
 * @module    Core
 * @package   Xeeo\Services\Core\Abstracts\Entity\Components
 *
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */
trait ExcludedClasses
{

    private $excludedClasses = array(
        'MongoId',
        'MongoCode',
        'MongoDate',
        'MongoRegex',
        'MongoBinData',
        'MongoInt32',
        'MongoInt64',
        'MongoDBRef',
        'MongoMinKey',
        'MongoMaxKey',
        'MongoTimestamp'
    );

    private function isClassExcluded($object) {

        $className = get_class($object);
        $className = trim($className, ' \\');

        return (in_array($className, $this->excludedClasses));
    }

}
