<?php
/**
 * EditController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\item;

use cookyii\modules\Feed;
use cookyii\modules\Feed\resources\FeedItem\Model as FeedItemModel;

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
        /** @var FeedItemModel $ItemModel */
        $ItemModel = \Yii::createObject(FeedItemModel::class);

        $ItemEditForm = \Yii::createObject([
            'class' => Feed\backend\forms\ItemEditForm::class,
            'Item' => $ItemModel,
        ]);

        return $this->render('index', [
            'ItemEditForm' => $ItemEditForm,
        ]);
    }
}