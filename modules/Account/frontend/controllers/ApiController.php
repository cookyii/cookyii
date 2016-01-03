<?php
/**
 * ApiController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\controllers;

use cookyii\modules\Account;

/**
 * Class ApiController
 * @package cookyii\modules\Account\frontend\controllers
 */
class ApiController extends \cookyii\api\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
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
                'title' => \Yii::t('cookyii.account', 'Sign in'),
                'text' => \Yii::t('cookyii', 'Unknown error'),
            ]
        ];

        /** @var Account\forms\SignInForm $SignInForm */
        $SignInForm = \Yii::createObject(Account\forms\SignInForm::className());

        if ($SignInForm->load(Request()->post()) && $SignInForm->validate() && $SignInForm->login()) {
            $result = [
                'result' => true,
                'message' => [
                    'title' => \Yii::t('cookyii.account', 'Sign in'),
                    'text' => \Yii::t('cookyii.account', 'Welcome!'),
                ],
                'redirect' => UrlManager()->createUrl(['/']),
            ];
        }

        if ($SignInForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => [
                    'title' => \Yii::t('cookyii.account', 'Sign in'),
                    'text' => \Yii::t('cookyii.account', 'Form errors.'),
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
                'title' => \Yii::t('cookyii.account', 'Sign up'),
                'text' => \Yii::t('cookyii', 'Unknown error'),
            ]
        ];

        /** @var Account\forms\SignUpForm $SignUpForm */
        $SignUpForm = \Yii::createObject(Account\forms\SignUpForm::className());

        if ($SignUpForm->load(Request()->post()) && $SignUpForm->validate() && $SignUpForm->register()) {
            $result = [
                'result' => true,
                'message' => [
                    'title' => \Yii::t('cookyii.account', 'Sign up'),
                    'text' => \Yii::t('cookyii.account', 'Welcome!'),
                ],
                'redirect' => UrlManager()->createUrl(['/']),
            ];
        }

        if ($SignUpForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => [
                    'title' => \Yii::t('cookyii.account', 'Sign up'),
                    'text' => \Yii::t('cookyii.account', 'Form errors.'),
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
                'title' => \Yii::t('cookyii.account', 'Forgot password'),
                'text' => \Yii::t('cookyii', 'Unknown error'),
            ]
        ];

        /** @var Account\forms\ForgotPasswordForm $ForgotPasswordForm */
        $ForgotPasswordForm = \Yii::createObject(Account\forms\ForgotPasswordForm::className());

        if ($ForgotPasswordForm->load(Request()->post()) && $ForgotPasswordForm->validate() && $ForgotPasswordForm->sendNotification()) {
            $result = [
                'result' => true,
                'message' => [
                    'title' => \Yii::t('cookyii.account', 'Forgot password'),
                    'text' => \Yii::t('cookyii.account', 'Email with instructions sent.'),
                ],
            ];
        }

        if ($ForgotPasswordForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => [
                    'title' => \Yii::t('cookyii.account', 'Forgot password'),
                    'text' => \Yii::t('cookyii.account', 'Form errors.'),
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
                'title' => \Yii::t('cookyii.account', 'Fill attributes'),
                'text' => \Yii::t('cookyii', 'Unknown error'),
            ]
        ];

        $Client = Session()->get('OAuthResponseClient');

        if (empty($Client)) {
            throw new \yii\web\BadRequestHttpException;
        }

        /** @var Account\forms\FillAttributesForm $FillAttributesForm */
        $FillAttributesForm = \Yii::createObject(Account\forms\FillAttributesForm::className());

        if ($FillAttributesForm->load(Request()->post()) && $FillAttributesForm->validate() && $FillAttributesForm->save($Client)) {
            $result = [
                'result' => true,
                'message' => [
                    'title' => \Yii::t('cookyii.account', 'Fill attributes'),
                    'text' => \Yii::t('cookyii.account', 'Welcome!'),
                ],
                'redirect' => UrlManager()->createUrl(['/account/sign/fill-redirect']),
            ];
        }

        if ($FillAttributesForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => [
                    'title' => \Yii::t('cookyii.account', 'Fill attributes'),
                    'text' => \Yii::t('cookyii.account', 'Form errors.'),
                ],
                'errors' => $FillAttributesForm->getFirstErrors(),
            ];
        }

        return $result;
    }
}