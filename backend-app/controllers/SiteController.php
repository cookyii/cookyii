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
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['/dash']);
    }
}