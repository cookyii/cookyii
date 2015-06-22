<?php
/**
 * TemplateController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
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
                'roles' => [Postman\backend\Permissions::POSTMAN_ACCESS],
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
        $TemplateEditForm = new Postman\backend\forms\TemplateEditForm([
            'Template' => new \resources\Postman\Template(),
        ]);

        return $this->render('edit', [
            'TemplateEditForm' => $TemplateEditForm,
        ]);
    }

    /**
     * @param $type
     * @param $subject
     * @param $content
     * @param $use_layout
     * @return string
     */
    public function actionPreview($type, $subject, $content, $use_layout)
    {
        $result = null;

        $use_layout = $use_layout === 'true';

        switch ($type) {
            default:
            case 'text':
                $Message = \resources\Postman\Message::compose($subject, $content, null, $use_layout);

                $result = Html::tag('pre', Html::encode($Message->content_text));
                break;
            case 'html':
                $Message = \resources\Postman\Message::compose($subject, null, $content, $use_layout);

                $result = $Message->content_html;
                break;
        }

        return $result;
    }
}