<?php
/**
 * ResentAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers\rest\MessageController;

/**
 * Class ResentAction
 * @package cookyii\modules\Postman\backend\controllers\rest\MessageController
 */
class ResentAction extends \cookyii\rest\Action
{

    /**
     * @param $id
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function run($id)
    {
        print_r($id);
        die();

        /** @var \cookyii\modules\Postman\resources\PostmanMessage $model */
        $model = $this->findModel($id);

        if ($model->send() !== true) {
            throw new \yii\web\ServerErrorHttpException('Failed to resent email the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }
}