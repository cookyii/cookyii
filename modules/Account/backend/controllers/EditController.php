<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\controllers;

use cookyii\modules\Account;

/**
 * Class EditController
 * @package cookyii\modules\Account\backend\controllers
 */
class EditController extends Account\backend\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => [Account\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        /** @var \cookyii\modules\Account\resources\Account $AccountModel */
        $AccountModel = \Yii::createObject(\cookyii\modules\Account\resources\Account::className());

        $AccountEditForm = new Account\backend\forms\AccountEditForm([
            'Account' => $AccountModel,
        ]);

        return $this->render('index', [
            'AccountEditForm' => $AccountEditForm,
        ]);
    }
}