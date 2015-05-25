<?php
/**
 * DefaultController.php
 * @author Revin Roman http://phptime.ru
 */

namespace crm\modules\Blank\controllers;

use crm\modules\Blank;

/**
 * Class DefaultController
 * @package crm\modules\Blank\controllers
 */
class DefaultController extends Blank\components\Controller
{

    public function actionIndex()
    {
        throw new \yii\web\ForbiddenHttpException;
    }
}