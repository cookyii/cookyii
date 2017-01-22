<?php
/**
 * QueueController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace console\controllers;

use cookyii\Decorator as D;
use cookyii\queue\Event;
use yii\helpers\Console;

/**
 * Class QueueController
 * @package console\controllers
 */
class QueueController extends \yii\console\Controller
{

    /**
     * @var integer
     * Delay before running first job in listening mode (in seconds)
     */
    public $timeout = 0;

    /**
     * @var integer
     * Delay after each step (in seconds)
     */
    public $sleep = 1;

    /**
     * @var bool
     * Need restart job if failure or not
     */
    public $restartOnFailure = true;

    /**
     * @var string
     * Queue component ID
     */
    public $queue = 'queue';

    const EVENT_BEFORE_PURGE = 'beforePurge';

    const EVENT_AFTER_PURGE = 'afterPurge';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->registerEventHandlers();
    }

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return ['restartOnFailure', 'queue', 'timeout', 'sleep', 'color', 'interactive'];
    }

    /**
     * Process a job
     * @param string $queueName
     * @throws \Exception
     */
    public function actionWork($queueName = null)
    {
        $this->process($queueName);
    }

    /**
     * Continuously process jobs
     * @param string $queueName
     * @return bool
     * @throws \Exception
     */
    public function actionListen($queueName = null)
    {
        $timeout = (int)$this->timeout;
        $startTime = time();

        while (true) {
            if (!empty($timeout) && ($startTime + $timeout) > time()) {
                return true;
            }

            $this->process($queueName);

            sleep($this->sleep);
        }

        return false;
    }

    /**
     * @param string $queueName
     */
    public function actionPurge($queueName)
    {
        $this->trigger(static::EVENT_BEFORE_PURGE, new Event(['queueName' => $queueName]));

        $this->getQueue()->purge($queueName);

        $this->stdout(sprintf('  > Queue `%s` purged.', $queueName) . "\n");

        $this->trigger(static::EVENT_AFTER_PURGE, new Event(['queueName' => $queueName]));
    }

    /**
     * Process one unit of job in queue
     * @param string $queueName
     * @return bool
     * @throws \Exception
     */
    protected function process($queueName)
    {
        $job = $this->getQueue()->pop($queueName);

        if (!empty($job) && is_array($job)) {
            try {
                /** @var \cookyii\queue\ActiveJob $jobObject */
                $jobObject = call_user_func($job['body']['serializer'][1], $job['body']['object']);
                $jobObject->controller = $this;

                $this->out(sprintf('Begin executing a job `%s`...', get_class($jobObject)));
                $this->sep('---------------------------------------');

                if ($jobObject->run() || (bool)$this->restartOnFailure === false) {
                    $this->getQueue()->delete($job);
                }

                $this->sep('End -----------------------------------');
                $this->out('');

                return true;
            } catch (\Exception $e) {
                $this->err($e->getMessage());
            }
        } else {
            $this->out(sprintf('Queue `%s` is empty.', $queueName));
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getTime()
    {
        return D::Formatter()->asTime(time(), 'HH:mm:ss');
    }

    /**
     * @param string $message
     * @param bool $nl
     */
    protected function out($message, $nl = true)
    {
        $message = empty($message)
            ? ''
            : sprintf('  %s > %s', $this->getTime(), $message);

        $nl = $nl ? "\n" : '';

        $this->stdout($message . $nl);
    }

    /**
     * @param string $message
     * @param bool $nl
     */
    protected function err($message, $nl = true)
    {
        $message = empty($message)
            ? ''
            : sprintf('  %s > Error: %s', $this->getTime(), $message);

        $nl = $nl ? "\n" : '';

        $this->stderr($message . $nl, Console::FG_RED);
    }

    /**
     * @param string $message
     * @param bool $nl
     */
    protected function sep($message, $nl = true)
    {
        $nl = $nl ? "\n" : '';

        $this->stdout('  ' . $message . $nl);
    }

    /**
     * @return \yii\queue\QueueInterface
     * @throws \yii\base\InvalidConfigException
     */
    public function getQueue()
    {
        return \Yii::$app->get($this->queue);
    }

    /**
     * Events handlers
     */
    protected function registerEventHandlers()
    {
        $this->on(static::EVENT_BEFORE_ACTION, function (\yii\base\ActionEvent $Event) {
            /** self $Controller */
            $Controller = $Event->sender;

            if (getenv('QUEUE_TIMEOUT')) {
                $Controller->timeout = (int)getenv('QUEUE_TIMEOUT') + time();
            }

            if (getenv('QUEUE_SLEEP')) {
                $Controller->sleep = (int)getenv('QUEUE_SLEEP');
            }
        });
    }
}