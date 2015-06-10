<?php
/**
 * RbacCommand.php
 * @author Revin Roman
 */

namespace common\commands;

use backend\Permissions as BP;
use common\Roles as R;
use frontend\Permissions as FP;
use rmrevin\yii\rbac\RbacFactory as RF;

/**
 * Class RbacCommand
 * @package common\commands
 */
class RbacCommand extends \rmrevin\yii\rbac\Command
{

    /** @var string|null */
    public $forceAssign = 'user';

    /**
     * @return \yii\rbac\Role[]
     */
    protected function roles()
    {
        return [
            RF::Role(R::ADMIN, 'Administrator'),
            RF::Role(R::MANAGER, 'Manager'),
            RF::Role(R::CLIENT, 'Client'),
            RF::Role(R::USER, 'User'),
        ];
    }

    /**
     * @return \yii\rbac\Rule[]
     */
    protected function rules()
    {
        return [];
    }

    /**
     * @return \yii\rbac\Permission[]
     */
    protected function permissions()
    {
        return array_merge(
            $this->frontendPermissions(),
            $this->backendPermissions()
        );
    }

    /**
     * @return array
     */
    private function frontendPermissions()
    {
        return [
            RF::Permission(FP::ACCESS, 'It has access to the frontend'),
        ];
    }

    /**
     * @return array
     */
    private function backendPermissions()
    {
        return [
            RF::Permission(BP::ACCESS, 'It has access to the backend'),
        ];
    }

    /**
     * @return array
     */
    protected function inheritanceRoles()
    {
        return [
            R::ADMIN => [
                R::MANAGER,
            ],
            R::MANAGER => [
                R::USER,
            ],
            R::CLIENT => [
                R::USER,
            ],
            R::USER => [],
        ];
    }

    /**
     * @return array
     */
    protected function inheritancePermissions()
    {
        return [
            R::ADMIN => [
            ],
            R::MANAGER => [
                BP::ACCESS,
            ],
            R::CLIENT => [
            ],
            R::USER => [
                FP::ACCESS,
            ],
        ];
    }
}