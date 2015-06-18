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
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => [\backend\Permissions::PAGE_ACCESS],
                    ],

                ],
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