<?php
/**
 * EchoJob.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\queue;

/**
 * Class EchoJob
 * @package cookyii\queue
 */
abstract class EchoJob extends BaseJob
{

    /**
     * @param string $message
     */
    protected function log($message)
    {
        // @todo
    }

    /**
     * @param string $message
     * @param mixed $extra
     */
    protected function logerr($message, $extra = null)
    {
        // @todo
    }
}
