<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\item\rest\ItemController;

use cookyii\modules\Feed;

/**
 * Class EditFormAction
 * @package cookyii\modules\Feed\backend\controllers\item\rest\ItemController
 */
class EditFormAction extends \cookyii\rest\Action
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

        /** @var $modelClass \cookyii\modules\Feed\resources\Feed\Item */
        $modelClass = $this->modelClass;

        $Item = null;

        if ($item_id > 0) {
            $Item = $modelClass::find()
                ->byId($item_id)
                ->one();
        }

        if (empty($Item)) {
            $Item = new $modelClass;
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
                'message' => \Yii::t('feed', 'Item successfully saved'),
                'item_id' => $Item->id,
                'item_slug' => $Item->slug,
            ];
        }

        return $result;
    }
}