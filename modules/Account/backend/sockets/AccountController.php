<?php
/**
 * AccountController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Account\backend\sockets;

/**
 * Class AccountController
 * @package cookyii\modules\Account\backend\sockets
 */
class AccountController extends \cookyii\socket\Controller
{

    /**
     * @inheritdoc
     */
    public function run(\Ratchet\ConnectionInterface $from, $message)
    {
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($this->serialize('account-list'));
            }
        }
    }
}