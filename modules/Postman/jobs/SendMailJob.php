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
            throw new \yii\base\ErrorException(\Yii::t('app.postman', 'Unable to determine the id of the message'));
        }

        $Message = PostmanMessage::find()
            ->byId($id)
            ->one();

        if (empty($Message)) {
            throw new \yii\base\ErrorException(\Yii::t('app.postman', 'Failed to find message'));
        }

        return $Message->send();
    }

    public function queueName()
    {
        return 'mail';
    }
}