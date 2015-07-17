<?php
/**
 * SiteController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
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
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index', 'error', 'captcha', 'tz'],
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
                'fixedVerifyCode' => YII_DEBUG ? 'random' : null,
            ],
            'tz' => [ // setting timezone
                'class' => 'cookyii\web\actions\TimeZoneAction',
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