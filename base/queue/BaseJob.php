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
}
