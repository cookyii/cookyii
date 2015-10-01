<?php
/**
 * ForgotPasswordController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\controllers;

use cookyii\modules\Account;

/**
 * Class ForgotPasswordController
 * @package cookyii\modules\Account\frontend\controllers
 */
class ForgotPasswordController extends Account\frontend\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index', 'check'],
                'roles' => ['?', '@'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $ForgotPasswordForm = \Yii::createObject(Account\frontend\forms\ForgotPasswordForm::className());

        $this->layout = '//wide';

        return $this->render('index', [
            'ForgotPasswordForm' => $ForgotPasswordForm,
        ]);
    }

    /**
     * @param string $email
     * @param string $hash
     * @return \yii\web\Response
     */
    public function actionCheck($email, $hash)
    {
        $ForgotPasswordForm = \Yii::createObject(Account\frontend\forms\ForgotPasswordForm::className());
        $ForgotPasswordForm->email = $email;
        $ForgotPasswordForm->hash = $hash;

        if ($ForgotPasswordForm->validateHash() && $ForgotPasswordForm->resetPassword()) {
            return $this->redirect(['/']);
        } else {
            return $this->redirect(['/account/forgot-password', 'bad' => 1]);
        }
    }
}