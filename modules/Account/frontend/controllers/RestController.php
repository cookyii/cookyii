<?php
/**
 * RestController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\controllers;

use cookyii\modules\Account;

/**
 * Class RestController
 * @package cookyii\modules\Account\frontend\controllers
 */
class RestController extends \cookyii\rest\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['in', 'up', 'forgot-password', 'fill'],
                'roles' => ['?', '@'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function verbs()
    {
        return [
            'in' => ['POST'],
            'up' => ['POST'],
            'forgot-password' => ['POST'],
            'fill' => ['POST'],
        ];
    }

    /**
     * @return array
     */
    public function actionIn()
    {
        $result = [
            'result' => false,
            'message' => [
                'title' => \Yii::t('account', 'Sign In'),
                'text' => \Yii::t('account', 'Unknown error.'),
            ]
        ];

        /** @var Account\frontend\forms\SignInForm $SignInForm */
        $SignInForm = \Yii::createObject(Account\frontend\forms\SignInForm::className());

        if ($SignInForm->load(Request()->post()) && $SignInForm->validate() && $SignInForm->login()) {
            $result = [
                'result' => true,
                'message' => [
                    'title' => \Yii::t('account', 'Sign In'),
                    'text' => \Yii::t('account', 'Welcome!'),
                ],
                'redirect' => UrlManager()->createUrl(['/']),
            ];
        }

        if ($SignInForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => [
                    'title' => \Yii::t('account', 'Sign In'),
                    'text' => \Yii::t('account', 'Form errors.'),
                ],
                'errors' => $SignInForm->getFirstErrors(),
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function actionUp()
    {
        $result = [
            'result' => false,
            'message' => [
                'title' => \Yii::t('account', 'Sign Up'),
                'text' => \Yii::t('account', 'Unknown error.'),
            ]
        ];

        /** @var Account\frontend\forms\SignUpForm $SignUpForm */
        $SignUpForm = \Yii::createObject(Account\frontend\forms\SignUpForm::className());

        if ($SignUpForm->load(Request()->post()) && $SignUpForm->validate() && $SignUpForm->register()) {
            $result = [
                'result' => true,
                'message' => [
                    'title' => \Yii::t('account', 'Sign Up'),
                    'text' => \Yii::t('account', 'Welcome!'),
                ],
                'redirect' => UrlManager()->createUrl(['/']),
            ];
        }

        if ($SignUpForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => [
                    'title' => \Yii::t('account', 'Sign Up'),
                    'text' => \Yii::t('account', 'Form errors.'),
                ],
                'errors' => $SignUpForm->getFirstErrors(),
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function actionForgotPassword()
    {
        $result = [
            'result' => false,
            'message' => [
                'title' => \Yii::t('account', 'Forgot password'),
                'text' => \Yii::t('account', 'Unknown error.'),
            ]
        ];

        /** @var Account\frontend\forms\ForgotPasswordForm $ForgotPasswordForm */
        $ForgotPasswordForm = \Yii::createObject(Account\frontend\forms\ForgotPasswordForm::className());

        if ($ForgotPasswordForm->load(Request()->post()) && $ForgotPasswordForm->validate() && $ForgotPasswordForm->sendNotification()) {
            $result = [
                'result' => true,
                'message' => [
                    'title' => \Yii::t('account', 'Forgot password'),
                    'text' => \Yii::t('account', 'Email with instructions sent.'),
                ],
            ];
        }

        if ($ForgotPasswordForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => [
                    'title' => \Yii::t('account', 'Forgot password'),
                    'text' => \Yii::t('account', 'Form errors.'),
                ],
                'errors' => $ForgotPasswordForm->getFirstErrors(),
            ];
        }

        return $result;
    }

    /**
     * @return array
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionFill()
    {
        $result = [
            'result' => false,
            'message' => [
                'title' => \Yii::t('account', 'Fill attributes'),
                'text' => \Yii::t('account', 'Unknown error.'),
            ]
        ];

        $Client = Session()->get('OAuthResponseClient');

        if (empty($Client)) {
            throw new \yii\web\BadRequestHttpException;
        }

        /** @var Account\frontend\forms\FillAttributesForm $FillAttributesForm */
        $FillAttributesForm = \Yii::createObject(Account\frontend\forms\FillAttributesForm::className());

        if ($FillAttributesForm->load(Request()->post()) && $FillAttributesForm->validate() && $FillAttributesForm->save($Client)) {
            $result = [
                'result' => true,
                'message' => [
                    'title' => \Yii::t('account', 'Fill attributes'),
                    'text' => \Yii::t('account', 'Welcome!'),
                ],
                'redirect' => UrlManager()->createUrl(['/']),
            ];
        }

        if ($FillAttributesForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => [
                    'title' => \Yii::t('account', 'Fill attributes'),
                    'text' => \Yii::t('account', 'Form errors.'),
                ],
                'errors' => $FillAttributesForm->getFirstErrors(),
            ];
        }

        return $result;
    }
}