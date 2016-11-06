<?php
/**
 * Connection.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\predis;

use Predis\Client as PredisClient;

/**
 * Class Connection
 * @package cookyii\predis
 */
class Connection extends \yii\base\Component
{

    /**
     * @var string
     */
    public $scheme = 'tcp';

    /**
     * @var string
     */
    public $hostname = 'localhost';

    /**
     * @var integer
     */
    public $port = 6379;

    /**
     * @var string|null
     */
    public $unixSocket;

    /**
     * @var string|null
     */
    public $password;

    /**
     * @var integer
     */
    public $database = 0;

    /**
     * @var bool
     */
    public $autoAuth = true;

    /**
     * @var bool
     */
    public $autoSelectDatabase = true;

    /**
     * @var PredisClient
     */
    private $_client;

    /**
     * Event after client init
     */
    const EVENT_AFTER_CLIENT_INIT = 'afterClientInit';

    /**
     * @return PredisClient
     */
    public function getClient()
    {
        if (empty($this->_client)) {
            $this->_client = new PredisClient([
                'scheme' => $this->scheme,
                'host' => $this->hostname,
                'port' => $this->port,
            ]);

            if ($this->autoAuth) {
                $this->_client->auth($this->password);
            }

            if ($this->autoSelectDatabase) {
                $this->_client->select($this->database);
            }

            $Event = new Event;
            $Event->client = $this->_client;

            $this->trigger(self::EVENT_AFTER_CLIENT_INIT, $Event);
        }

        return $this->_client;
    }
}
