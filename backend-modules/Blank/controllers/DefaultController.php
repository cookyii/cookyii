<?php
/**
 * DefaultController.php
 * @author Revin Roman
 */

namespace backend\modules\Blank\controllers;

use backend\modules\Blank;

/**
 * Class DefaultController
 * @package backend\modules\Blank\controllers
 */
class DefaultController extends Blank\components\Controller
{

    public function actionIndex()
    {
        throw new \yii\web\ForbiddenHttpException;
    }
}