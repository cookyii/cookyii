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
        /** @var \cookyii\modules\Postman\resources\Postman\Template $model */
        $model = $this->findModel($id);

        $result = $model->attributes;

        $result['use_layout'] = $result['use_layout'] === \cookyii\modules\Postman\resources\Postman\Template::USE_LAYOUT;

        $result['address'] = empty($result['address'])
            ? null
            : Json::decode($result['address']);

        $result['params'] = empty($result['params'])
            ? null
            : Json::decode($result['params']);

        $result['params'][] = [
            'key' => 'host',
            'description' => 'Http host of current site',
            'default' => true,
        ];

        $result['params'][] = [
            'key' => 'appname',
            'description' => 'Current application name',
            'default' => true,
        ];

        $result['params'][] = [
            'key' => 'subject',
            'description' => 'Subject of current letter',
            'default' => true,
        ];

        $result['params'][] = [
            'key' => 'user_id',
            'description' => 'ID of current user',
            'default' => true,
        ];

        $result['params'][] = [
            'key' => 'username',
            'description' => 'Name of current user',
            'default' => true,
        ];

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}