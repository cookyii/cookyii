<?php
/**
 * RolesDictInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\interfaces;

/**
 * Interface RolesDictInterface
 * @package cookyii\interfaces
 */
interface RolesDictInterface
{

    /**
     * @return array
     */
    public static function get();

    /**
     * @return array
     */
    public static function inheritance();
}
