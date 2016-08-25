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

    public function dumpSchema();

    public function dumpData();

    public function restoreDump($variant);
}