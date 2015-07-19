<?php
/**
 * SocketCommand.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace backend\commands;

/**
 * Class SocketCommand
 * @package backend\commands
 */
class SocketCommand extends \cookyii\socket\commands\SocketCommand
{

    public $defaultAction = 'run';

    protected $loadRoutesFromModules = true;

    /**
     * @inheritdoc
     */
    protected function getRoutes()
    {
        return [
            [
                'path' => '/udp',
                'controller' => new \cookyii\socket\controllers\UdpController,
            ],
        ];
    }

    public function actionRun()
    {
        $this->runSocket(getenv('BACKEND_DOMAIN'));
    }
}