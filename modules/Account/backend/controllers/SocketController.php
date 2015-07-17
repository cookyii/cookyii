<?php
/**
 * SocketController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Account\backend\controllers;

/**
 * Class SocketController
 * @package cookyii\modules\Account\backend\controllers
 */
class SocketController extends \yii\rest\Controller
{

    public $defaultAction = 'run';

    public function actionRun()
    {
        $loop = \React\EventLoop\Factory::create();

        $socket = new \React\Socket\Server($loop);
        $socket->on('connection', function ($conn) {
            $conn->write("Hello there!\n");
            $conn->write("Welcome to this amazing server!\n");
            $conn->write("Here's a tip: don't say anything.\n");

            $conn->on('data', function ($data) use ($conn) {
                $conn->close();
            });
        });

        $socket->listen(1337);

        $loop->run();
    }
}