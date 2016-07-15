<?php
/**
 * PermissionsDictInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\interfaces;

/**
 * Interface PermissionsDictInterface
 * @package cookyii\interfaces
 */
interface PermissionsDictInterface
{

    /**
     * @return array
     */
    public static function get();

    /**
     * @return array
     */
    public static function rules();

    /**
     * @return array
     */
    public static function inheritance();
}
