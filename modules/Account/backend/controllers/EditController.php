<?php
/**
 * EditController.php
 * @author Revin Roman
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
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [\backend\Permissions::ACCOUNT_ACCESS],
                    ],

                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $AccountEditForm = new Account\backend\forms\AccountEditForm(['User' => new \resources\User()]);

        return $this->render('index', [
            'AccountEditForm' => $AccountEditForm,
        ]);
    }
}