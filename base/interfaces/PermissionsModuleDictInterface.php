<?php
/**
 * PermissionsModuleDictInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\interfaces;

/**
 * Interface PermissionsModuleDictInterface
 * @package cookyii\interfaces
 */
interface PermissionsModuleDictInterface
{

    /**
     * @return array
     */
    public static function get();

    /**
     * @return array
     */
    public static function rules();
}
