<?php
/**
 * BackendModuleInterface.php
 * @author Revin Roman
 */

namespace backend\interfaces;

/**
 * Interface BackendModuleInterface
 * @package backend\interfaces
 */
interface BackendModuleInterface
{

    /**
     * @param \backend\components\Controller $Controller
     * @return array
     */
    public function menu($Controller);
}