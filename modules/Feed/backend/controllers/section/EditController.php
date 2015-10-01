<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\section;

use cookyii\modules\Feed;

/**
 * Class EditController
 * @package cookyii\modules\Feed\backend\controllers\section
 */
class EditController extends Feed\backend\components\Controller
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
        /** @var \cookyii\modules\Feed\resources\Feed\Section $SectionModel */
        $SectionModel = \Yii::createObject(\cookyii\modules\Feed\resources\Feed\Section::className());

        $SectionEditForm = new Feed\backend\forms\SectionEditForm([
            'Section' => $SectionModel,
        ]);

        return $this->render('index', [
            'SectionEditForm' => $SectionEditForm,
        ]);
    }
}