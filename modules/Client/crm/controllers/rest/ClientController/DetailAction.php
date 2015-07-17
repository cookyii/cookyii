<?php
/**
 * DetailAction.php
 * @author Revin Roman
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
        $model = $this->findModel($id);

        $result = $model->attributes;

        $result['properties'] = [];

        $properties = $model->properties();
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
     * @return \resources\Client
     */
    public function findModel($id)
    {
        /* @var $modelClass \resources\Client */
        $modelClass = $this->modelClass;

        $model = $modelClass::find()
            ->byId($id)
            ->with(['properties'])
            ->one();

        if (isset($model)) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException(sprintf('Object not found: %s', $id));
        }
    }
}