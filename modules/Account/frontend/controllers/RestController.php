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
                'actions' => ['in', 'up', 'forgot-password'],
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

        $SignInForm = new Account\frontend\forms\SignInForm();

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

        $SignUpForm = new Account\frontend\forms\SignUpForm();

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

        $ForgotPasswordForm = new Account\frontend\forms\ForgotPasswordForm();

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
}