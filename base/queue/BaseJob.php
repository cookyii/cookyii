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
    private $timing = [
        'start' => null,
        'done'  => null,
    ];

    /**
     * @var array
     */
    private $logs = [];

    /**
     * BaseJob constructor.
     */
    public function __construct()
    {
        $this->id = md5(uniqid(mt_rand()));
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
        return !empty($this->timing['start']);
    }

    /**
     * @return bool
     */
    public function isTimerStopped()
    {
        return !empty($this->timing['done']);
    }

    public function startTimer()
    {
        $this->timing['start'] = microtime(true);
        $this->timing['done'] = null;
    }

    public function stopTimer()
    {
        $this->timing['done'] = microtime(true);
    }

    /**
     * @return bool|int
     */
    public function getDuration()
    {
        return !empty($this->timing['start']) && !empty($this->timing['done'])
            ? (int)round($this->timing['done'] - $this->timing['start'], 0)
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
    protected function log($message)
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
    protected function logerr($message, $extra = null)
    {
        $this->logs[] = [
            'date'    => new \DateTime,
            'type'    => 'error',
            'message' => $message,
            'extra'   => $extra,
        ];
    }
}
