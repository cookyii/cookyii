<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers\rest\TemplateController;

/**
 * Class DetailAction
 * @package cookyii\modules\Postman\backend\controllers\rest\TemplateController
 */
class DetailAction extends \cookyii\rest\Action
{

    /**
     * @param integer $id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        /** @var \cookyii\modules\Postman\resources\PostmanTemplate $Model */
        $Model = $this->findModel($id);

        $result = $Model->toArray();

        /** @var \cookyii\modules\Postman\resources\PostmanTemplate $TemplateModel */
        $TemplateModel = \Yii::createObject(\cookyii\modules\Postman\resources\PostmanTemplate::className());

        $result['use_layout'] = $result['use_layout'] === $TemplateModel::USE_LAYOUT;

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