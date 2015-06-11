<?php
/**
 * ListController.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\modules\Account\controllers;

use backend\modules\Account;

/**
 * Class ListController
 * @package backend\modules\Account\controllers
 */
class ListController extends Account\components\Controller
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