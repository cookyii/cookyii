<?php
/**
 * ActiveJob.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\queue;

/**
 * Class ActiveJob
 * @package cookyii\queue
 */
abstract class ActiveJob extends \yii\base\Object
{

    /** @var mixed */
    public $queue = 'queue';

    /** @var array */
    public $serializer = ['serialize', 'unserialize'];

    /** @var \yii\console\Controller */
    public $controller;

    /**
     * Runs the job.
     */
    abstract public function run();

    /**
     * @return string
     */
    abstract public function queueName();

    /**
     * Pushs the job.
     *
     * @param integer $delay
     * @return string
     */
    public function push($delay = 0)
    {
        return $this->getQueue()->push([
            'serializer' => $this->serializer,
            'object' => call_user_func($this->serializer[0], $this),
        ], $this->queueName(), $delay);
    }

    /**
     * @return ActiveJob|null
     */
    public static function pop()
    {
        /** @var self $Job */
        $Job = new static;

        $job = $Job->getQueue()
            ->pop($Job->queueName());

        return empty($job)
            ? null
            : call_user_func($job['body']['serializer'][1], $job['body']['object']);
    }

    /**
     * Purges the queue.
     */
    public function purge()
    {
        $this->getQueue()->purge($this->queueName());
    }

    /**
     * Releases the message.
     *
     * @param array $message
     * @param integer $delay
     */
    public function release(array $message, $delay = 0)
    {
        $this->getQueue()->release($message, $delay);
    }

    /**
     * Deletes the message.
     *
     * @param array $message
     */
    public function delete($message)
    {
        $this->getQueue()->delete($message);
    }

    /**
     * @return \yii\queue\QueueInterface
     */
    public function getQueue()
    {
        return \Yii::$app->get($this->queue);
    }
}
