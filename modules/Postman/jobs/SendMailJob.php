<?php
/**
 * SendMailJob.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\jobs;

use cookyii\modules\Postman\resources\PostmanMessage\Model as PostmanMessageModel;
use cookyii\queue\BaseJob;
use yii\base\ErrorException;
use yii\helpers\Json;

/**
 * Class SendMailJob
 * @package cookyii\modules\Postman\jobs
 */
class SendMailJob extends BaseJob
{

    /**
     * @var integer
     */
    public $postmanMessageId;

    /**
     * @param \yii\queue\Queue $queue
     * @return bool
     * @throws \Exception
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\ErrorException
     */
    public function execute($queue)
    {
        $id = $this->postmanMessageId;

        if (empty($id)) {
            throw new ErrorException(\Yii::t('cookyii.postman', 'Unable to determine the id of the message'));
        }

        /** @var PostmanMessageModel $MessageModel */
        $MessageModel = \Yii::createObject(PostmanMessageModel::class);

        $Message = $MessageModel::find()
            ->byId($id)
            ->one();

        if (empty($Message)) {
            throw new ErrorException(\Yii::t('cookyii.postman', 'Failed to find message'));
        }

        $result = $Message->sendImmediately();

        if ($Message->hasErrors()) {
            $errors = $Message->getErrors();

            $Message->error = Json::encode($errors);
            $Message->validate() && $Message->save();
        } elseif (is_bool($result) && $result === false) {
            $Postman = $MessageModel::getPostman();

            $Message->repeatAfter($Postman->resentTry, $Postman->resentOffset);
        } else {
            throw new ErrorException(\Yii::t('cookyii.postman', 'Emergency response'));
        }

        return $result;
    }
}
