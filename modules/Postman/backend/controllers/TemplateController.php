<?php
/**
 * TemplateController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers;

use cookyii\modules\Postman;
use yii\helpers\Html;

/**
 * Class TemplateController
 * @package cookyii\modules\Postman\backend\controllers
 */
class TemplateController extends Postman\backend\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['list', 'edit', 'preview'],
                'roles' => [Postman\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * @return string
     */
    public function actionEdit()
    {
        /** @var \cookyii\modules\Postman\resources\PostmanTemplate $TemplateModel */
        $TemplateModel = \Yii::createObject(\cookyii\modules\Postman\resources\PostmanTemplate::className());

        $TemplateEditForm = \Yii::createObject([
            'class' => Postman\backend\forms\TemplateEditForm::className(),
            'Template' => $TemplateModel,
        ]);

        return $this->render('edit', [
            'TemplateEditForm' => $TemplateEditForm,
        ]);
    }

    /**
     * @param string $type
     * @param string $subject
     * @param string $content
     * @param string $styles
     * @param boolean $use_layout
     * @return string
     */
    public function actionPreview($type, $subject, $content, $styles, $use_layout)
    {
        $result = null;

        $use_layout = $use_layout === 'true';

        /** @var \cookyii\modules\Postman\resources\PostmanMessage $MessageModel */
        $MessageModel = \Yii::createObject(\cookyii\modules\Postman\resources\PostmanMessage::className());

        switch ($type) {
            default:
            case 'text':
                $Message = $MessageModel::compose($subject, $content, null, [], $styles, $use_layout);

                $result = Html::tag('pre', Html::encode($Message->content_text));
                break;
            case 'html':
                $Message = $MessageModel::compose($subject, null, $content, [], $styles, $use_layout);

                $result = $Message->content_html;
                break;
        }

        return $result;
    }
}