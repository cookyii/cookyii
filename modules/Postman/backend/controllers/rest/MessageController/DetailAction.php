<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers\rest\MessageController;

/**
 * Class DetailAction
 * @package cookyii\modules\Postman\backend\controllers\rest\MessageController
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
        /** @var \cookyii\modules\Postman\resources\PostmanMessage\Model $Model */
        $Model = $this->findModel($id);

        $result = $Model->toArray();

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}