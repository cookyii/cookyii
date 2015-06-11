<?php
/**
 * RestoreAction.php
 * @author Revin Roman
 */

namespace common\rest;

/**
 * Class RestoreAction
 * @package common\rest
 */
class RestoreAction extends \yii\rest\Action
{
    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @throws \yii\web\ServerErrorHttpException on failure.
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if (!method_exists($model, 'restore')) {
            throw new \yii\web\ServerErrorHttpException('Failed to restore the object because the model is no method `restore`.');
        }

        if ($model->restore() === false) {
            throw new \yii\web\ServerErrorHttpException('Failed to restore the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }
}