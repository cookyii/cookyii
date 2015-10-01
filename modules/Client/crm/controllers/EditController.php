<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\controllers;

use cookyii\modules\Client;

/**
 * Class EditController
 * @package cookyii\modules\Client\crm\controllers
 */
class EditController extends Client\crm\components\Controller
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
                'roles' => [Client\crm\Permissions::ACCESS],
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

        $ClientEditForm = new Client\crm\forms\ClientEditForm([
            'Client' => $ClientModel,
        ]);

        return $this->render('index', [
            'ClientEditForm' => $ClientEditForm,
        ]);
    }
}