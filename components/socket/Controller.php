<?php
/**
 * Controller.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\socket;

use yii\helpers\Json;

/**
 * Class Controller
 * @package cookyii\socket
 */
abstract class Controller implements \Ratchet\MessageComponentInterface
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
     * @param \Ratchet\ConnectionInterface $from
     * @param string $message
     */
    abstract public function run(\Ratchet\ConnectionInterface $from, $message);

    /**
     * @param mixed $data
     * @return string
     */
    protected function serialize($data)
    {
        return Json::encode($data);
    }

    /**
     * @param string $data
     * @return mixed
     */
    protected function unserialize($data)
    {
        return Json::decode($data);
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
        $message = $this->unserialize($message);

        if ($message === 'hello') {
            return;
        }

        $this->run($from, $message);
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