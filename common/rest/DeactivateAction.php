<?php
/**
 * DeactivateAction.php
 * @author Revin Roman
 */

namespace common\rest;

/**
 * Class DeactivateAction
 * @package common\rest
 */
class DeactivateAction extends \yii\rest\Action
{

    /**
     * Deactivate a model.
     * @param mixed $id id of the model to be deactivated.
     * @throws \yii\web\ServerErrorHttpException on failure.
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if (!method_exists($model, 'deactivate')) {
            throw new \yii\web\ServerErrorHttpException('Failed to deactivate the object because the model is no method `deactivate`.');
        }

        if ($model->deactivate() === false) {
            throw new \yii\web\ServerErrorHttpException('Failed to deactivate the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }
}