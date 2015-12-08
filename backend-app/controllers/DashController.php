<?php
/**
 * DashController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace backend\controllers;

/**
 * Class DashController
 * @package backend\controllers
 */
class DashController extends \backend\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => ['@'],
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