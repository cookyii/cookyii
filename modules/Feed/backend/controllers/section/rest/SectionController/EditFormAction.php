<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\controllers\section\rest\SectionController;

use cookyii\modules\Feed;

/**
 * Class EditFormAction
 * @package cookyii\modules\Feed\backend\controllers\section\rest\SectionController
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

        $section_slug = str_clean(Request()->post('section_slug'));

        /** @var \cookyii\modules\Feed\resources\Feed\Section|null $Section */
        $Section = null;

        if (!empty($section_slug)) {
            $Section = \cookyii\modules\Feed\resources\Feed\Section::find()
                ->bySlug($section_slug)
                ->one();
        }

        if (empty($Section)) {
            $Section = new \cookyii\modules\Feed\resources\Feed\Section();
        }

        $SectionEditForm = new Feed\backend\forms\SectionEditForm(['Section' => $Section]);

        $SectionEditForm->load(Request()->post())
        && $SectionEditForm->validate()
        && $SectionEditForm->save();

        if ($SectionEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('feed', 'When executing a query the error occurred'),
                'errors' => $SectionEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('feed', 'Section successfully saved'),
                'section_id' => $Section->id,
                'section_slug' => $Section->slug,
            ];
        }

        return $result;
    }
}