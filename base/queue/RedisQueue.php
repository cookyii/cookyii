<?php
/**
 * RedisQueue.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\queue;

use Predis\Transaction\MultiExec;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

/**
 * Class RedisQueue
 * @package cookyii\queue
 */
class RedisQueue extends \yii\queue\RedisQueue
{

    /**
     * @var integer
     */
    public $database = 0;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->redis === null) {
            throw new InvalidConfigException('The "redis" property must be set.');
        }

        if (is_string($this->redis)) {
            $this->redis = \Yii::$app->get($this->redis);
        }

        parent::init();

        $this->selectDatabase($this->database);
    }

    /**
     * @param integer $number
     */
    public function selectDatabase($number)
    {
        $this->redis->select((int)$number);
    }

    /**
     * @inheritdoc
     */
    public function pop($queue)
    {
        foreach ([':delayed', ':reserved'] as $type) {
            $options = ['cas' => true, 'watch' => $queue . $type];
            $this->redis->transaction($options, function (MultiExec $transaction) use ($queue, $type) {
                $data = $this->redis->zrangebyscore($queue . $type, '-inf', $time = time());
                if (!empty($data)) {
                    $transaction->zremrangebyscore($queue . $type, '-inf', $time);
                    $transaction->rpush($queue, $data);
                }
            });
        }

        $raw = $this->redis->lpop($queue);
        if ($raw === null) {
            return false;
        }

        $this->redis->zadd($queue . ':reserved', [$raw => time() + $this->expire]);
        $data = Json::decode($raw);

        return [
            'id' => $data['id'],
            'queue' => $queue,
            'body' => $data['body'],
            'raw' => $raw,
        ];
    }

    /**
     * @inheritdoc
     */
    public function delete(array $message)
    {
        $this->redis->zrem($message['queue'] . ':reserved', $message['raw']);
    }
}
