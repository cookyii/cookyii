<?php
/**
 * ApiController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\controllers;

use cookyii\modules\Account;

/**
 * Class ApiController
 * @package cookyii\modules\Account\backend\controllers
 */
class ApiController extends \cookyii\rest\Controller
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
}