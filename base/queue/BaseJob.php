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

    private $id;

    private $timing = [
        'start' => null,
        'done'  => null,
    ];

    private $logs = [];

    public function __construct()
    {
        $this->id = md5(uniqid(mt_rand()));
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    public function startTimer()
    {
        $this->timing['start'] = microtime(true);
    }

    public function stopTimer()
    {
        $this->timing['done'] = microtime(true);
    }

    /**
     * @return bool|float
     */
    public function getDuration()
    {
        return !empty($this->timing['start']) && !empty($this->timing['done'])
            ? round($this->timing['done'] - $this->timing['start'], 4)
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
