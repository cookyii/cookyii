<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers\rest\MessageController;

use yii\helpers\Json;

/**
 * Class DetailAction
 * @package cookyii\modules\Postman\backend\controllers\rest\MessageController
 */
class DetailAction extends \yii\rest\Action
{

    /**
     * @param integer $id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        /** @var \cookyii\modules\Postman\resources\Postman\Message $model */
        $model = $this->findModel($id);

        $result = $model->attributes;

        $result['address'] = empty($result['address'])
            ? null
            : Json::decode($result['address']);

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}