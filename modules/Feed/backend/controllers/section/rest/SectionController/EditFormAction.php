<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\section\rest\SectionController;

use cookyii\modules\Feed;

/**
 * Class EditFormAction
 * @package cookyii\modules\Feed\backend\controllers\section\rest\SectionController
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
            'message' => \Yii::t('cookyii.feed', 'Unknown error'),
        ];

        $section_slug = str_clean(Request()->post('section_slug'));

        /** @var $modelClass \cookyii\modules\Feed\resources\FeedSection */
        $modelClass = $this->modelClass;

        $Section = null;

        if (!empty($section_slug)) {
            $Section = $modelClass::find()
                ->bySlug($section_slug)
                ->one();
        }

        if (empty($Section)) {
            $Section = new $modelClass;
        }

        $SectionEditForm = \Yii::createObject([
            'class' => Feed\backend\forms\SectionEditForm::className(),
            'Section' => $Section,
        ]);

        $SectionEditForm->load(Request()->post())
        && $SectionEditForm->validate()
        && $SectionEditForm->save();

        if ($SectionEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('cookyii.feed', 'When executing a query the error occurred'),
                'errors' => $SectionEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('cookyii.feed', 'Section successfully saved'),
                'section_id' => $Section->id,
                'section_slug' => $Section->slug,
            ];
        }

        return $result;
    }
}