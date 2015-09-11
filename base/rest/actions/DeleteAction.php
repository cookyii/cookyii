<?php
/**
 * DeleteAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\rest\actions;

/**
 * Class DeleteAction
 * @package cookyii\rest\actions
 */
class DeleteAction extends \yii\rest\Action
{

    /**
     * Restore a model.
     * @param mixed $id id of the model to be restored.
     * @throws \yii\web\ServerErrorHttpException on failure.
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if (!method_exists($model, 'delete')) {
            throw new \yii\web\ServerErrorHttpException('Failed to restore the object because the model is no method `delete`.');
        }

        if ($model->delete() === false) {
            throw new \yii\web\ServerErrorHttpException('Failed to restore the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }
}