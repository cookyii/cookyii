<?php
/**
 * SortController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Feed\backend\controllers\section\rest;

/**
 * Class SortController
 * @package cookyii\modules\Feed\backend\controllers\section\rest
 */
class SortController extends \yii\rest\Controller
{

    /**
     * @param integer|null $parent_section_id
     * @return int
     */
    public function actionIndex($parent_section_id = null)
    {
        $parent_section_id = empty($parent_section_id)
            ? null
            : $parent_section_id;

        return (int)\resources\Feed\Section::find()
            ->byParentId($parent_section_id)
            ->withoutDeleted()
            ->max('sort');
    }
}