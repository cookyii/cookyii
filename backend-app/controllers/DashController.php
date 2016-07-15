<?php
/**
 * DashController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace backend\controllers;

use backend\Permissions;

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
                'roles' => [Permissions::ACCESS],
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