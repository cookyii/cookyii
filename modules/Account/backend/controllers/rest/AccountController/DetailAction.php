<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\controllers\rest\AccountController;

/**
 * Class DetailAction
 * @package cookyii\modules\Account\backend\controllers\rest\AccountController
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
        /** @var $modelClass \cookyii\modules\Account\resources\Account\Model */
        $modelClass = $this->modelClass;

        $Account = $modelClass::find()
            ->byId($id)
            ->with(['properties'])
            ->one();

        if (empty($Account)) {
            throw new \yii\web\NotFoundHttpException;
        }

        $result = $Account->toArray([], ['roles', 'permissions', 'properties']);

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}