<?php
/**
 * ListController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Client\crm\controllers;

use cookyii\modules\Client;

/**
 * Class ListController
 * @package cookyii\modules\Client\crm\controllers
 */
class ListController extends Client\crm\components\Controller
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
                'roles' => [Client\crm\Permissions::ACCESS],
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