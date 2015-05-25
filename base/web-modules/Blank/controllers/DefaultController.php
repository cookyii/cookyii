<?php
/**
 * DefaultController.php
 * @author Revin Roman http://phptime.ru
 */

namespace web\modules\Blank\controllers;

use web\modules\Blank;

/**
 * Class DefaultController
 * @package web\modules\Blank\controllers
 */
class DefaultController extends Blank\components\Controller
{

    public function actionIndex()
    {
        throw new \yii\web\ForbiddenHttpException;
    }
}