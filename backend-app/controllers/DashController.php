<?php
/**
 * DashController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace backend\controllers;

/**
 * Class DashController
 * @package backend\controllers
 */
class DashController extends \backend\components\Controller
{

    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}