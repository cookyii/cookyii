<?php
/**
 * ListController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Page\backend\controllers;

use cookyii\modules\Page;

/**
 * Class ListController
 * @package cookyii\modules\Page\backend\controllers
 */
class ListController extends Page\backend\components\Controller
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
                'roles' => [Page\backend\Permissions::PAGE_ACCESS],
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