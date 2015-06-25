<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\controllers\item\rest\ItemController;

use cookyii\modules\Feed;

/**
 * Class EditFormAction
 * @package cookyii\modules\Feed\backend\controllers\item\rest\ItemController
 */
class EditFormAction extends \yii\rest\Action
{

    /**
     * @return array
     */
    public function run()
    {
        $result = [
            'result' => false,
            'message' => \Yii::t('feed', 'Unknown error'),
        ];

        $item_id = (int)Request()->post('item_id');

        /** @var \resources\Feed\Item|null $Item */
        $Item = null;

        if ($item_id > 0) {
            $Item = \resources\Feed\Item::find()
                ->byId($item_id)
                ->one();
        }

        if (empty($Item)) {
            $Item = new \resources\Page();
        }

        $ItemEditForm = new Feed\backend\forms\ItemEditForm(['Item' => $Item]);

        $ItemEditForm->load(Request()->post())
        && $ItemEditForm->validate()
        && $ItemEditForm->save();

        if ($ItemEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('feed', 'When executing a query the error occurred'),
                'errors' => $ItemEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('feed', 'Page successfully saved'),
                'item_id' => $Item->id,
            ];
        }

        return $result;
    }
}