<?php
/**
 * SiteController.php
 * @author Revin Roman http://phptime.ru
 */

namespace frontend\controllers;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends \frontend\components\Controller
{

    public $public = true;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_DEBUG ? 'testme' : null,
            ],
        ];
    }

    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        throw new \yii\web\NotFoundHttpException;
    }
}