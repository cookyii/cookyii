<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\controllers\rest\ClientController;

/**
 * Class DetailAction
 * @package cookyii\modules\Client\crm\controllers\rest\ClientController
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
        $Model = $this->findModel($id);
        $Account = $Model->account;

        $result = $Model->attributes;

        $result['account'] = empty($Account) ? null : $Account->attributes;
        $result['properties'] = [];

        $properties = $Model->properties();
        if (!empty($properties)) {
            foreach ($properties as $key => $values) {
                $result['properties'][$key] = $values;
            }
        }

        $result['hash'] = sha1(serialize($result));

        return $result;
    }

    /**
     * @inheritdoc
     * @return \cookyii\modules\Client\resources\Client
     */
    public function findModel($id)
    {
        /* @var $ModelClass \cookyii\modules\Client\resources\Client */
        $ModelClass = $this->modelClass;

        $Model = $ModelClass::find()
            ->byId($id)
            ->with(['properties'])
            ->one();

        if (isset($Model)) {
            return $Model;
        } else {
            throw new \yii\web\NotFoundHttpException(sprintf('Object not found: %s', $id));
        }
    }
}