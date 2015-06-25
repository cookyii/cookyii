<?php
/**
 * EditController.php
 * @author Revin Roman
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
        $ItemEditForm = new Feed\backend\forms\ItemEditForm([
            'Item' => new \resources\Feed\Item(),
        ]);

        return $this->render('index', [
            'ItemEditForm' => $ItemEditForm,
        ]);
    }
}