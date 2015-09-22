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

        $result = $Model->attributes;
        unset($result['password_hash'], $result['token'], $result['auth_key']);

        $result['roles'] = [];
        $result['permissions'] = [];
        $result['properties'] = [];

        $roles = AuthManager()->getRolesByUser($Model->id);
        foreach ($roles as $role => $conf) {
            $result['roles'][$role] = true;
        }
        $result['roles'][\common\Roles::USER] = true;

        $permissions = AuthManager()->getPermissionsByUser($Model->id);
        foreach ($permissions as $permission => $conf) {
            $result['permissions'][$permission] = true;
        }

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
     * @return \cookyii\modules\Account\resources\Account
     */
    public function findModel($id)
    {
        /* @var $modelClass \cookyii\modules\Account\resources\Account */
        $modelClass = $this->modelClass;

        $Model = $modelClass::find()
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