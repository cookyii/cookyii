<?php
/**
 * CrmModuleInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace crm\interfaces;

/**
 * Interface CrmModuleInterface
 * @package crm\interfaces
 */
interface CrmModuleInterface
{

    /**
     * @param \crm\components\Controller $Controller
     * @return array
     */
    public function menu($Controller);
}