<?php
/**
 * SendMailJob.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\jobs;

use cookyii\modules\Postman\resources\PostmanMessage;

/**
 * Class SendMailJob
 * @package cookyii\modules\Postman\jobs
 */
class SendMailJob extends \cookyii\queue\ActiveJob
{

    /** @var integer */
    public $postmanMessageId;

    public function run()
    {
        $id = $this->postmanMessageId;

        if (empty($id)) {
            throw new \yii\base\ErrorException('Не определён id сообщения');
        }

        $Message = PostmanMessage::find()
            ->byId($id)
            ->one();

        if (empty($Message)) {
            throw new \yii\base\ErrorException('Не удалось найти запись сообщения');
        }

        return $Message->send();
    }

    public function queueName()
    {
        return 'mail';
    }
}