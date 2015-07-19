<?php
/**
 * UdpController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\socket\controllers;

/**
 * Class UdpController
 * @package cookyii\socket\controllers
 */
class UdpController extends \cookyii\socket\Controller implements \Ratchet\MessageComponentInterface
{

    /**
     * @inheritdoc
     */
    public function run(\Ratchet\ConnectionInterface $from, $message)
    {
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($this->serialize($message));
            }
        }
    }
}