<?php
/**
 * TreeAction.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Feed\backend\controllers\section\rest\SectionController;

/**
 * Class TreeAction
 * @package cookyii\modules\Feed\backend\controllers\section\rest\SectionController
 */
class TreeAction extends \yii\rest\Action
{

    /**
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        /* @var $modelClass \resources\Feed\Section */
        $modelClass = $this->modelClass;

        $with_deleted = Request()->get('deleted', 'false') === 'true';

        /** @var \resources\Feed\queries\SectionQuery $SectionsQuery */
        $SectionsQuery = \resources\Feed\Section::find();

        if ($with_deleted === false) {
            $SectionsQuery->withoutDeleted();
        }

        $Sections = $SectionsQuery
            ->orderBy(['id' => SORT_ASC])
            ->all();

        return $modelClass::getTree($Sections);
    }
}