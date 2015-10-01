<?php
/**
 * TreeAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\section\rest\SectionController;

/**
 * Class TreeAction
 * @package cookyii\modules\Feed\backend\controllers\section\rest\SectionController
 */
class TreeAction extends \cookyii\rest\Action
{

    /**
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        /* @var $modelClass \cookyii\modules\Feed\resources\Feed\Section */
        $modelClass = $this->modelClass;

        $with_deleted = Request()->get('deleted', 'false') === 'true';

        return $modelClass::getTree($with_deleted);
    }
}