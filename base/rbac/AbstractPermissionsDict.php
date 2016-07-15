<?php
/**
 * AbstractPermissionsDict.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\rbac;

use cookyii\interfaces\PermissionsDictInterface;
use cookyii\interfaces\PermissionsModuleDictInterface;

/**
 * Class AbstractPermissionsDict
 * @package cookyii\rbac
 */
abstract class AbstractPermissionsDict implements PermissionsDictInterface
{

    /**
     * @var array
     */
    static $merge = [];

    /**
     * @param array $classes
     * @return array
     */
    public static function expandPermissions(array $classes)
    {
        return static::_classIterator($classes, function ($class) {
            return (array)call_user_func([$class, 'get']);
        });
    }

    /**
     * @param array $classes
     * @return array
     */
    public static function expandRules(array $classes)
    {
        return static::_classIterator($classes, function ($class) {
            return (array)call_user_func([$class, 'rules']);
        });
    }

    /**
     * @param array $classes
     * @param callable $handler
     * @return array
     */
    public static function _classIterator(array $classes, $handler)
    {
        $result = [];

        if (!empty($classes)) {
            foreach ($classes as $class) {
                if (!class_exists($class)) {
                    echo sprintf('----- Merge class `%s` not exists.', $class) . PHP_EOL;
                    continue;
                }

                $obj = new $class;

                if (!($obj instanceof PermissionsModuleDictInterface)) {
                    echo sprintf('----- Merge class `%s` not implement `PermissionsModuleDictInterface`.', $class) . PHP_EOL;
                    continue;
                }

                if (is_callable($handler)) {
                    $data = call_user_func($handler, $class);

                    if (!empty($data)) {
                        $result = array_merge($result, $data);
                    }
                }
            }
        }

        return $result;
    }
}
