<?php
/**
 * EditController.php
 * @author Revin Roman
 */

namespace backend\modules\Account\controllers;

use backend\modules\Account;

/**
 * Class EditController
 * @package backend\modules\Account\controllers
 */
class EditController extends Account\components\Controller
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
        $AccountEditForm = new Account\forms\AccountEditForm(['User' => new \resources\User()]);

        return $this->render('index', [
            'AccountEditForm' => $AccountEditForm,
        ]);
    }
}