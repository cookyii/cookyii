<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\backend\controllers;

use cookyii\modules\Client;

/**
 * Class EditController
 * @package cookyii\modules\Client\backend\controllers
 */
class EditController extends Client\backend\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => [Client\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        /** @var \cookyii\modules\Client\resources\Client $ClientModel */
        $ClientModel = \Yii::createObject(\cookyii\modules\Client\resources\Client::className());

        $ClientEditForm = \Yii::createObject([
            'class' => Client\backend\forms\ClientEditForm::className(),
            'Client' => $ClientModel,
        ]);

        return $this->render('index', [
            'ClientEditForm' => $ClientEditForm,
        ]);
    }
}