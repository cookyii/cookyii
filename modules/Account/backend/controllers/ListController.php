<?php
/**
 * ListController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\backend\controllers;

use cookyii\modules\Account;

/**
 * Class ListController
 * @package cookyii\modules\Account\backend\controllers
 */
class ListController extends Account\backend\components\Controller
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
                'roles' => [Account\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}