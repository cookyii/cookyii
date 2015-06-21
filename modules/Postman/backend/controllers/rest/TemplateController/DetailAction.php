<?php
/**
 * DetailAction.php
 * @author Revin Roman
 */

namespace cookyii\modules\Postman\backend\controllers\rest\TemplateController;

use yii\helpers\Json;

/**
 * Class DetailAction
 * @package cookyii\modules\Postman\backend\controllers\rest\TemplateController
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
        /** @var \resources\Postman\Template $model */
        $model = $this->findModel($id);

        $result = $model->attributes;

        $result['address'] = empty($result['address'])
            ? null
            : Json::decode($result['address']);

        $result['params'] = empty($result['params'])
            ? null
            : Json::decode($result['params']);

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}