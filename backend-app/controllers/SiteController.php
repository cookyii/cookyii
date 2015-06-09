<?php
/**
 * SiteController.php
 * @author Revin Roman
 */

namespace backend\controllers;

/**
 * Class SiteController
 * @package backend\controllers
 */
class SiteController extends \backend\components\Controller
{

    public $public = true;

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
                'fixedVerifyCode' => YII_DEBUG ? 'random' : null,
            ],
        ];
    }

    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        throw new \yii\web\ServerErrorHttpException('Under construction');
    }
}