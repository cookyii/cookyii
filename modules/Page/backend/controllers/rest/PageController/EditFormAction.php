<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 */

namespace cookyii\modules\Page\backend\controllers\rest\PageController;

use cookyii\modules\Page;

/**
 * Class EditFormAction
 * @package cookyii\modules\Page\backend\controllers\rest\PageController
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
            'message' => \Yii::t('page', 'Unknown error'),
        ];

        $page_id = (int)Request()->post('page_id');

        /** @var \cookyii\modules\Page\resources\Page|null $Page */
        $Page = null;

        if ($page_id > 0) {
            $Page = \cookyii\modules\Page\resources\Page::find()
                ->byId($page_id)
                ->one();
        }

        if (empty($Page)) {
            $Page = new \cookyii\modules\Page\resources\Page();
        }

        $PageEditForm = new Page\backend\forms\PageEditForm(['Page' => $Page]);

        $PageEditForm->load(Request()->post())
        && $PageEditForm->validate()
        && $PageEditForm->save();

        if ($PageEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('page', 'When executing a query the error occurred'),
                'errors' => $PageEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('page', 'Page successfully saved'),
                'page_id' => $Page->id,
            ];
        }

        return $result;
    }
}