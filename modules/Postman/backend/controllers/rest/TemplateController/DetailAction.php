<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers\rest\TemplateController;

use cookyii\modules\Postman\resources\PostmanTemplate\Model as PostmanTemplateModel;

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
        /** @var PostmanTemplateModel $Model */
        $Model = $this->findModel($id);

        $result = $Model->toArray();

        /** @var PostmanTemplateModel $TemplateModel */
        $TemplateModel = \Yii::createObject(PostmanTemplateModel::class);

        $result['use_layout'] = $result['use_layout'] === $TemplateModel::USE_LAYOUT;

        $result['params'][] = [
            'key' => 'host',
            'description' => \Yii::t('cookyii.postman', 'Http host of current site'),
            'default' => true,
        ];

        $result['params'][] = [
            'key' => 'domain',
            'description' => \Yii::t('cookyii.postman', 'Domain of current site'),
            'default' => true,
        ];

        $result['params'][] = [
            'key' => 'appname',
            'description' => \Yii::t('cookyii.postman', 'Current application name'),
            'default' => true,
        ];

        $result['params'][] = [
            'key' => 'subject',
            'description' => \Yii::t('cookyii.postman', 'Subject of current letter'),
            'default' => true,
        ];

        $result['params'][] = [
            'key' => 'user_id',
            'description' => \Yii::t('cookyii.postman', 'ID of current user'),
            'default' => true,
        ];

        $result['params'][] = [
            'key' => 'username',
            'description' => \Yii::t('cookyii.postman', 'Name of current user'),
            'default' => true,
        ];

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}