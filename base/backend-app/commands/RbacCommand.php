<?php
/**
 * RbacCommand.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\commands;

use backend\Permissions as P;
use rmrevin\yii\rbac\RbacFactory as RF;

/**
 * Class RbacCommand
 * @package backend\commands
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
            RF::Role(P::ROLE_ADMIN, 'Administrator'),
            RF::Role(P::ROLE_MANAGER, 'Manager'),
            RF::Role(P::ROLE_CLIENT, 'Client'),
            RF::Role(P::ROLE_USER, 'User'),
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
        return [
            RF::Permission(P::ACCESS, 'It has access to the backend'),
        ];
    }

    /**
     * @return array
     */
    protected function inheritanceRoles()
    {
        return [
            P::ROLE_ADMIN => [
                P::ROLE_MANAGER,
            ],
            P::ROLE_MANAGER => [
                P::ROLE_USER,
            ],
            P::ROLE_CLIENT => [
                P::ROLE_USER,
            ],
            P::ROLE_USER => [],
        ];
    }

    /**
     * @return array
     */
    protected function inheritancePermissions()
    {
        return [
            P::ROLE_ADMIN => [
            ],
            P::ROLE_MANAGER => [
            ],
            P::ROLE_CLIENT => [
                P::ACCESS,
            ],
            P::ROLE_USER => [],
        ];
    }
}