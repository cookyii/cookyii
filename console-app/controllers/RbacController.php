<?php
/**
 * RbacController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace console\controllers;

/**
 * Class RbacController
 * @package console\controllers
 */
class RbacController extends \rmrevin\yii\rbac\Command
{

    public $defaultAction = 'update';

    /** @var string|null */
    public $forceAssign = 'user';

    /**
     * @return \yii\rbac\Role[]
     */
    protected function roles()
    {
        return \common\Roles::get();
    }

    /**
     * @return \yii\rbac\Rule[]
     */
    protected function rules()
    {
        return array_merge(
            \frontend\Permissions::rules(),
            \backend\Permissions::rules()
        );
    }

    /**
     * @return \yii\rbac\Permission[]
     */
    protected function permissions()
    {
        return array_merge(
            \frontend\Permissions::get(),
            \backend\Permissions::get()
        );
    }

    /**
     * @return array
     */
    protected function inheritanceRoles()
    {
        return \common\Roles::inheritance();
    }

    /**
     * @return array
     */
    protected function inheritancePermissions()
    {
        return array_merge_recursive(
            \frontend\Permissions::inheritance(),
            \backend\Permissions::inheritance()
        );
    }
}
