<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\controllers;

use cookyii\modules\Client;

/**
 * Class EditController
 * @package cookyii\modules\Client\crm\controllers
 */
class EditController extends Client\crm\components\Controller
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
        $ClientEditForm = new Client\crm\forms\ClientEditForm([
            'Client' => new \cookyii\modules\Client\resources\Client(),
        ]);

        return $this->render('index', [
            'ClientEditForm' => $ClientEditForm,
        ]);
    }
}