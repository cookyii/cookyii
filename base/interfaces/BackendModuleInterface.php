<?php
/**
 * BackendModuleInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\interfaces;

/**
 * Interface BackendModuleInterface
 * @package cookyii\interfaces
 */
interface BackendModuleInterface
{

    /**
     * @param \backend\components\Controller $Controller
     * @return array
     */
    public function menu($Controller);
}
