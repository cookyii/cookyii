<?php
/**
 * SiteController.php
 * @author Revin Roman http://phptime.ru
 */

namespace crm\controllers;

/**
 * Class SiteController
 * @package crm\controllers
 */
class SiteController extends \crm\components\Controller
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