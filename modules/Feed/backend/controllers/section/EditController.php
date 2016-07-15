<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\section;

use cookyii\modules\Feed;
use cookyii\modules\Feed\resources\FeedSection\Model as FeedSectionModel;

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
        /** @var FeedSectionModel $SectionModel */
        $SectionModel = \Yii::createObject(FeedSectionModel::className());

        $SectionEditForm = \Yii::createObject([
            'class' => Feed\backend\forms\SectionEditForm::className(),
            'Section' => $SectionModel,
        ]);

        return $this->render('index', [
            'SectionEditForm' => $SectionEditForm,
        ]);
    }
}
