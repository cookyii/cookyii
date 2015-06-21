<?php
/**
 * DefaultController.php
 * @author Some Developer
 */

namespace backend\modules\Blank\controllers;

use backend\modules\Blank;

/**
 * Class DefaultController
 * @package backend\modules\Blank\controllers
 */
class DefaultController extends Blank\components\Controller
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
                'roles' => ['@', '?'],
            ],
        ];
    }

    public function actionIndex()
    {
        throw new \yii\web\ForbiddenHttpException;
    }
}