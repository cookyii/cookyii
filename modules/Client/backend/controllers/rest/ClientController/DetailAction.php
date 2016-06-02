<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\backend\controllers\rest\ClientController;

/**
 * Class DetailAction
 * @package cookyii\modules\Client\backend\controllers\rest\ClientController
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
        /** @var $modelClass \cookyii\modules\Client\resources\Client */
        $modelClass = $this->modelClass;

        $Client = $modelClass::find()
            ->byId($id)
            ->with(['account', 'properties'])
            ->one();

        if (empty($Client)) {
            throw new \yii\web\NotFoundHttpException;
        }

        $result = $Client->toArray([], ['account', 'properties']);

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}