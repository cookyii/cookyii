<?php
/**
 * DefaultController.php
 * @author Some Developer
 */

namespace crm\modules\Blank\controllers;

use crm\modules\Blank;

/**
 * Class DefaultController
 * @package crm\modules\Blank\controllers
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