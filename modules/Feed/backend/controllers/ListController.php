<?php
/**
 * ListController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Feed\backend\controllers;

use cookyii\modules\Feed;

/**
 * Class ListController
 * @package cookyii\modules\Feed\backend\controllers
 */
class ListController extends Feed\backend\components\Controller
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
                'roles' => [Feed\backend\Permissions::ACCESS],
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