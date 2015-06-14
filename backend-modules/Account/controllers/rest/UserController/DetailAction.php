<?php
/**
 * DetailAction.php
 * @author Revin Roman
 */

namespace backend\modules\Account\controllers\rest\UserController;

/**
 * Class DetailAction
 * @package backend\modules\Account\controllers\rest\UserController
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
        unset($result['password_hash'], $result['token'], $result['auth_key']);

        $result['roles'] = [];
        $result['permissions'] = [];
        $result['properties'] = [];

        $roles = AuthManager()->getRolesByUser($model->id);
        foreach ($roles as $role => $conf) {
            $result['roles'][$role] = true;
        }

        $permissions = AuthManager()->getPermissionsByUser($model->id);
        foreach ($permissions as $permission => $conf) {
            $result['permissions'][$permission] = true;
        }

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
     * @return \resources\User
     */
    public function findModel($id)
    {
        /* @var $modelClass \resources\User */
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