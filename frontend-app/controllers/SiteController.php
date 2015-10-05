<?php
/**
 * SiteController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace frontend\controllers;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends \frontend\components\Controller
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
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_DEBUG ? 'cookyii' : null,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionTerms()
    {
        return $this->render('terms');
    }
}