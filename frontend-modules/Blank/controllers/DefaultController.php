<?php
/**
 * DefaultController.php
 * @author Some Developer
 */

namespace frontend\modules\Blank\controllers;

use frontend\modules\Blank;

/**
 * Class DefaultController
 * @package frontend\modules\Blank\controllers
 */
class DefaultController extends Blank\components\Controller
{

    public function actionIndex()
    {
        throw new \yii\web\ForbiddenHttpException;
    }
}