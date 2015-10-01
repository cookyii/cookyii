<?php
/**
 * MessageController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers;

use cookyii\modules\Postman;
use yii\helpers\Html;

/**
 * Class MessageController
 * @package cookyii\modules\Postman\backend\controllers
 */
class MessageController extends Postman\backend\components\Controller
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
        /** @var \cookyii\modules\Postman\resources\Postman\Message $MessageModel */
        $MessageModel = \Yii::createObject(\cookyii\modules\Postman\resources\Postman\Message::className());

        $MessageEditForm = new Postman\backend\forms\MessageEditForm([
            'Message' => $MessageModel,
        ]);

        return $this->render('edit', [
            'MessageEditForm' => $MessageEditForm,
        ]);
    }

    /**
     * @param string $type
     * @param string $subject
     * @param string $content
     * @param string $use_layout
     * @return string
     */
    public function actionPreview($type, $subject, $content, $use_layout)
    {
        $result = null;

        $use_layout = $use_layout === 'true';

        /** @var \cookyii\modules\Postman\resources\Postman\Message $MessageModel */
        $MessageModel = \Yii::createObject(\cookyii\modules\Postman\resources\Postman\Message::className());

        switch ($type) {
            default:
            case 'text':
                $Message = $MessageModel::compose($subject, $content, null, [], null, $use_layout);

                $result = Html::tag('pre', Html::encode($Message->content_text));
                break;
            case 'html':
                $Message = $MessageModel::compose($subject, null, $content, [], null, $use_layout);

                $result = $Message->content_html;
                break;
        }

        return $result;
    }
}