<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\item;

use cookyii\modules\Feed;

/**
 * Class EditController
 * @package cookyii\modules\Feed\backend\controllers\item
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
        /** @var \cookyii\modules\Feed\resources\FeedItem $ItemModel */
        $ItemModel = \Yii::createObject(\cookyii\modules\Feed\resources\FeedItem::className());

        $ItemEditForm = \Yii::createObject([
            'class' => Feed\backend\forms\ItemEditForm::className(),
            'Item' => $ItemModel,
        ]);

        return $this->render('index', [
            'ItemEditForm' => $ItemEditForm,
        ]);
    }
}