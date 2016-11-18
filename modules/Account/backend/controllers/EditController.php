<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\controllers;

use cookyii\modules\Account;
use cookyii\modules\Account\resources\Account\Model as AccountModel;

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
        /** @var AccountModel $AccountModel */
        $AccountModel = \Yii::createObject(AccountModel::class);

        $AccountEditForm = \Yii::createObject([
            'class' => Account\backend\forms\AccountEditForm::class,
            'Account' => $AccountModel,
        ]);

        return $this->render('index', [
            'AccountEditForm' => $AccountEditForm,
        ]);
    }
}