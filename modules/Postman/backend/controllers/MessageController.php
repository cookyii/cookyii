<?php
/**
 * MessageController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Postman\backend\controllers;

use cookyii\modules\Postman;

/**
 * Class MessageController
 * @package cookyii\modules\Postman\backend\controllers
 */
class MessageController extends Postman\backend\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['list'],
                'roles' => [Postman\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }
}