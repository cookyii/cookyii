<?php
/**
 * DetailAction.php
 * @author Revin Roman
 */

namespace cookyii\modules\Page\backend\controllers\rest\PageController;

/**
 * Class DetailAction
 * @package cookyii\modules\Page\backend\controllers\rest\PageController
 */
class DetailAction extends \yii\rest\Action
{

    /**
     * @param integer $id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        /** @var \cookyii\modules\Page\resources\Page $model */
        $model = $this->findModel($id);

        $result = $model->attributes;

        $meta = $model->meta();
        if (!empty($meta)) {
            foreach ($meta as $k => $v) {
                $key = sprintf('meta_%s', $k);
                $result[$key] = $v;
            }
        }

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}