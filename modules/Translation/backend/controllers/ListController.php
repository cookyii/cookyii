<?php
/**
 * ListController.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Translation\backend\controllers;

use cookyii\modules\Translation;

/**
 * Class ListController
 * @package cookyii\modules\Translation\backend\controllers
 */
class ListController extends Translation\backend\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => [Translation\backend\Permissions::ACCESS],
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