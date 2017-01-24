<?php
/**
 * SendMailJob.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\jobs;

use cookyii\modules\Postman\resources\PostmanMessage\Model as PostmanMessageModel;
use yii\helpers\Json;

/**
 * Class SendMailJob
 * @package cookyii\modules\Postman\jobs
 */
class SendMailJob extends \cookyii\queue\ActiveJob
{

    /** @var integer */
    public $postmanMessageId;

    /**
     * @return array|bool
     * @throws \yii\base\ErrorException
     */
    public function run()
    {
        $id = $this->postmanMessageId;

        if (empty($id)) {
            throw new \yii\base\ErrorException(\Yii::t('cookyii.postman', 'Unable to determine the id of the message'));
        }

        /** @var PostmanMessageModel $MessageModel */
        $MessageModel = \Yii::createObject(PostmanMessageModel::class);

        $Message = $MessageModel::find()
            ->byId($id)
            ->one();

        if (empty($Message)) {
            throw new \yii\base\ErrorException(\Yii::t('cookyii.postman', 'Failed to find message'));
        }

        $result = $Message->sendImmediately();

        if ($Message->hasErrors()) {
            $errors = $Message->getErrors();

            $Message->error = Json::encode($errors);
            $Message->validate() && $Message->save();
        } elseif (is_bool($result) && $result === true) {
        } elseif (is_bool($result) && $result === false) {
            $Postman = $MessageModel::getPostman();

            $Message->repeatAfter($Postman->resentTry, $Postman->resentOffset);
        } else {
            throw new \yii\base\ErrorException(\Yii::t('cookyii.postman', 'Emergency response'));
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function queueName()
    {
        return 'cookyii-mail-queue';
    }
}