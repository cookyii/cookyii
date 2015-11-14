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
        /** @var \cookyii\modules\Feed\resources\FeedSection $SectionModel */
        $SectionModel = \Yii::createObject(\cookyii\modules\Feed\resources\FeedSection::className());

        $SectionEditForm = \Yii::createObject([
            'class' => Feed\backend\forms\SectionEditForm::className(),
            'Section' => $SectionModel,
        ]);

        return $this->render('index', [
            'SectionEditForm' => $SectionEditForm,
        ]);
    }
}