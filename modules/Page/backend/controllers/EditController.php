<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
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
        /** @var \cookyii\modules\Page\resources\Page $PageModel */
        $PageModel = \Yii::createObject(\cookyii\modules\Page\resources\Page::className());

        $PageEditForm = \Yii::createObject([
            'class' => Page\backend\forms\PageEditForm::className(),
            'Page' => $PageModel,
        ]);

        return $this->render('index', [
            'PageEditForm' => $PageEditForm,
        ]);
    }
}