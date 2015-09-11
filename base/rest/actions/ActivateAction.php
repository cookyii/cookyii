<?php
/**
 * ActivateAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\rest\actions;

/**
 * Class ActivateAction
 * @package cookyii\rest\actions
 */
class ActivateAction extends \yii\rest\Action
{

    /**
     * Activate a model.
     * @param mixed $id id of the model to be activated.
     * @throws \yii\web\ServerErrorHttpException on failure.
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if (!method_exists($model, 'activate')) {
            throw new \yii\web\ServerErrorHttpException('Failed to activate the object because the model is no method `activate`.');
        }

        if ($model->activate() === false) {
            throw new \yii\web\ServerErrorHttpException('Failed to activate the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(204);
    }
}