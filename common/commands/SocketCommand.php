<?php
/**
 * SocketCommand.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\commands;

/**
 * Class SocketCommand
 * @package common\commands
 */
class SocketCommand extends \yii\console\Controller
{

    /**
     * @param int $port
     * @throws \React\Socket\ConnectionException
     */
    public function actionRun($port = 18665)
    {
        echo 'New web socket listening...';

        $app = new \Ratchet\App(getenv('BACKEND_DOMAIN'), $port);
        $app->route('/udp', new \cookyii\socket\UdpComponent);
        $app->run();
    }
}