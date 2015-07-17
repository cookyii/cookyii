<?php
/**
 * UdpComponent.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\socket;

use yii\helpers\Json;

/**
 * Class UdpComponent
 * @package cookyii\socket
 */
class UdpComponent implements \Ratchet\MessageComponentInterface
{

    /** @var \Ratchet\ConnectionInterface[] */
    protected $clients = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    /**
     * @inheritdoc
     */
    public function onOpen(\Ratchet\ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    /**
     * @inheritdoc
     */
    public function onMessage(\Ratchet\ConnectionInterface $from, $message)
    {
        $message = Json::decode($message);

        if ($message === 'hello') {
            return;
        }

        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send(Json::encode($message));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function onClose(\Ratchet\ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    /**
     * @inheritdoc
     */
    public function onError(\Ratchet\ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}