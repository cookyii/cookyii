<?php
/**
 * DriverInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\backup\drivers;

/**
 * Interface DriverInterface
 * @package cookyii\backup\drivers
 */
interface DriverInterface
{

    /**
     * @return string
     */
    public function dumpSchema();

    /**
     * @return string
     */
    public function dumpData();

    /**
     * @param string $variant
     */
    public function restoreDump($variant);
}
