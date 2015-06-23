<?php
/**
 * EditController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Page\backend\controllers;

use cookyii\modules\Page;

/**
 * Class EditController
 * @package cookyii\modules\Page\backend\controllers
 */
class EditController extends Page\backend\components\Controller
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
                'roles' => [Page\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $PageEditForm = new Page\backend\forms\PageEditForm([
            'Page' => new \resources\Page(),
        ]);

        return $this->render('index', [
            'PageEditForm' => $PageEditForm,
        ]);
    }
}