<?php
/**
 * ListController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Client\backend\controllers;

use cookyii\modules\Client;

/**
 * Class ListController
 * @package cookyii\modules\Client\backend\controllers
 */
class ListController extends Client\backend\components\Controller
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
                'roles' => [Client\backend\Permissions::ACCESS],
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