<?php
/**
 * BaseJob.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\queue;

use yii\base\Object;
use yii\queue\Job;

/**
 * Class BaseJob
 * @package cookyii\queue
 */
abstract class BaseJob extends Object implements Job
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $timer = [
        'start' => null,
        'done'  => null,
    ];

    /**
     * @var array
     */
    private $logs = [];

    /**
     * BaseJob constructor.
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->id = md5(uniqid(mt_rand(), true));
    }

    /**
     * @return array
     */
    abstract public function exportData();

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isTimerStarted()
    {
        return !empty($this->timer['start']);
    }

    /**
     * @return bool
     */
    public function isTimerStopped()
    {
        return !empty($this->timer['done']);
    }

    public function startTimer()
    {
        $this->timer['start'] = microtime(true);
        $this->timer['done'] = null;
    }

    public function stopTimer()
    {
        $this->timer['done'] = microtime(true);
    }

    /**
     * @return bool|float
     */
    public function getDuration()
    {
        return !empty($this->timer['start']) && !empty($this->timer['done'])
            ? round($this->timer['done'] - $this->timer['start'], 4)
            : false;
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @param string $message
     */
    public function log($message)
    {
        $this->logs[] = [
            'date'    => new \DateTime,
            'type'    => 'info',
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param mixed $extra
     */
    public function logerr($message, $extra = null)
    {
        $this->logs[] = [
            'date'    => new \DateTime,
            'type'    => 'error',
            'message' => $message,
            'extra'   => $extra,
        ];
    }
}
