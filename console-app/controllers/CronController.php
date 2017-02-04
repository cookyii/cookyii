<?php
/**
 * CronController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace console\controllers;

use cookyii\console\DaemonOutputTrait;
use cookyii\Facade as F;
use yii\helpers\VarDumper;

/**
 * Class CronController
 * @package console\controllers
 */
class CronController extends \yii\console\Controller
{

    use DaemonOutputTrait;

    /**
     * @var array
     */
    public $jobs = [];

    /**
     * @var array
     */
    public $executed = [];

    /**
     * @var integer
     * Delay before running first job in listening mode (in seconds)
     */
    public $timeout = 0;

    /**
     * @var integer
     */
    public $pingTimeout = 60;

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
     * @var integer
     */
    public $maxTries = 5;

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return ['restartOnFailure', 'timeout', 'sleep', 'color', 'interactive'];
    }

    /**
     * Process a job
     * @throws \Exception
     */
    public function actionWork()
    {
        $this->execute();
    }

    /**
     * Continuously process jobs
     * @return bool
     * @throws \Exception
     */
    public function actionListen()
    {
        $timeout = (int)$this->timeout;
        $startTime = time();

        while (true) {
            if (!empty($timeout) && ($startTime + $timeout) > time()) {
                return true;
            }

            $this->execute();

            sleep($this->sleep);
        }

        return false;
    }

    static $ping_timer;

    /**
     * Process one unit of job in queue
     * @return bool
     */
    protected function execute()
    {
        $start = microtime(true);

        $jobs = $this->jobs;

        $current = F::Formatter()->asDatetime(time(), 'yyyy-MM-dd HH:mm');

        foreach ($jobs as $job_class) {
            /** @var \cookyii\queue\CronJob $Job */
            $Job = new $job_class;

            if (!isset($this->executed[$job_class])) {
                $this->executed[$job_class] = null;
            }

            // если не нужно выполнять задачу в данный период времени
            // или
            // эта задача уже выполнялась в эту минуту
            // то пропускаем выполнение задачи
            if (!$Job->isNeedExecute() || $this->executed[$job_class] === $current) {
                continue;
            }

            $Job->controller = $this;

            $result = false;

            try {
                $this->out(sprintf('Begin executing a job `%s`...', $job_class));
                $this->sep('---------------------------------------');

                $result = $Job->schedule();

                $this->sep('End -----------------------------------');
                $this->out('');

            } catch (\Exception|\Error $e) {
                echo VarDumper::dumpAsString($e, 2);
            } finally {

                $duration = microtime(true) - $start;

                $this->executed[$job_class] = F::Formatter()->asDatetime(time(), 'yyyy-MM-dd HH:mm');

                static::$ping_timer = null;

                return $result;
            }
        }

        return false;
    }

}
