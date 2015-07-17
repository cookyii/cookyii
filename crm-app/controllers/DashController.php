<?php
/**
 * DashController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace crm\controllers;

/**
 * Class DashController
 * @package crm\controllers
 */
class DashController extends \crm\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index'],
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