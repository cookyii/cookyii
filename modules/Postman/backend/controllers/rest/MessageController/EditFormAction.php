<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers\rest\MessageController;

use cookyii\modules\Postman;

/**
 * Class EditFormAction
 * @package cookyii\modules\Postman\backend\controllers\rest\MessageController
 */
class EditFormAction extends \cookyii\rest\Action
{

    /**
     * @return array
     */
    public function run()
    {
        $result = [
            'result' => false,
            'message' => \Yii::t('postman', 'Unknown error'),
        ];

        $message_id = (int)Request()->post('message_id');

        /** @var $modelClass \cookyii\modules\Postman\resources\Postman\Message */
        $modelClass = $this->modelClass;

        $Message = null;

        if ($message_id > 0) {
            $Message = $modelClass::find()
                ->byId($message_id)
                ->one();
        }

        if (empty($Message)) {
            $Message = new $modelClass;
        }

        $MessageEditForm = new Postman\backend\forms\MessageEditForm(['Message' => $Message]);

        $MessageEditForm->load(Request()->post())
        && $MessageEditForm->validate()
        && $MessageEditForm->save();

        if ($MessageEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('postman', 'When executing a query the error occurred'),
                'errors' => $MessageEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('postman', 'Message successfully saved'),
                'message_id' => $MessageEditForm->Message->id,
            ];
        }

        return $result;
    }
}