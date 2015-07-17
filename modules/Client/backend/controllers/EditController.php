<?php
/**
 * EditController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Client\backend\controllers;

use cookyii\modules\Client;

/**
 * Class EditController
 * @package cookyii\modules\Client\backend\controllers
 */
class EditController extends Client\backend\components\Controller
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
        $ClientEditForm = new Client\backend\forms\ClientEditForm([
            'Client' => new \resources\Client(),
        ]);

        return $this->render('index', [
            'ClientEditForm' => $ClientEditForm,
        ]);
    }
}