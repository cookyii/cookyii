<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\backend\controllers\rest\PageController;

/**
 * Class DetailAction
 * @package cookyii\modules\Page\backend\controllers\rest\PageController
 */
class DetailAction extends \cookyii\rest\Action
{

    /**
     * @param integer $id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        /** @var \cookyii\modules\Page\resources\Page\Model $Model */
        $Model = $this->findModel($id);

        $result = $Model->toArray([], ['meta']);

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}