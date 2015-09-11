<?php
/**
 * ResentAction.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Postman\backend\controllers\rest\MessageController;

/**
 * Class ResentAction
 * @package cookyii\modules\Postman\backend\controllers\rest\MessageController
 */
class ResentAction extends \yii\rest\Action
{

    /**
     * @param $id
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function run($id)
    {
        /** @var \cookyii\modules\Postman\resources\Postman\Message $model */
        $model = $this->findModel($id);

        if ($model->send() !== true) {
            throw new \yii\web\ServerErrorHttpException('Failed to resent email the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }
}