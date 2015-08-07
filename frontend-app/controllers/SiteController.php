<?php
/**
 * SiteController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
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
                'actions' => ['index', 'error', 'captcha'],
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
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}