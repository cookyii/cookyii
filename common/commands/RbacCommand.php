<?php
/**
 * RbacCommand.php
 * @author Revin Roman
 */

namespace common\commands;

use backend;
use common\Roles;
use cookyii\modules\Account;
use cookyii\modules\Page;
use frontend;
use rmrevin\yii\rbac\RbacFactory as F;

/**
 * Class RbacCommand
 * @package common\commands
 */
class RbacCommand extends \rmrevin\yii\rbac\Command
{

    /** @var string|null */
    public $forceAssign = 'user';

    /** @var array */
    public $frontendMerge = [];

    /** @var array */
    public $backendMerge = [
        'cookyii\modules\Account\backend\Permissions',
        'cookyii\modules\Page\backend\Permissions',
    ];

    /**
     * @return \yii\rbac\Role[]
     */
    protected function roles()
    {
        return [
            F::Role(Roles::ADMIN, 'Administrator'),
            F::Role(Roles::MANAGER, 'Manager'),
            F::Role(Roles::CLIENT, 'Client'),
            F::Role(Roles::USER, 'User'),
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
        return array_merge(
            [
                F::Permission(frontend\Permissions::ACCESS, 'It has access to the frontend'),
            ],
            $this->expandMergeClasses($this->frontendMerge)
        );
    }

    /**
     * @return array
     */
    private function backendPermissions()
    {
        return array_merge(
            [
                F::Permission(backend\Permissions::ACCESS, 'It has access to the backend'),
                F::Permission(backend\Permissions::ACCESS, 'It has access to the backend'),
            ],
            $this->expandMergeClasses($this->backendMerge)
        );
    }

    /**
     * @return array
     */
    protected function inheritanceRoles()
    {
        return [
            Roles::ADMIN => [
                Roles::MANAGER,
            ],
            Roles::MANAGER => [
                Roles::USER,
            ],
            Roles::CLIENT => [
                Roles::USER,
            ],
            Roles::USER => [],
        ];
    }

    /**
     * @return array
     */
    protected function inheritancePermissions()
    {
        return [
            Roles::ADMIN => [
                Account\backend\Permissions::ACCOUNT_ACCESS,
            ],
            Roles::MANAGER => [
                backend\Permissions::ACCESS,
                Page\backend\Permissions::PAGE_ACCESS,
            ],
            Roles::CLIENT => [
            ],
            Roles::USER => [
                frontend\Permissions::ACCESS,
            ],
        ];
    }

    /**
     * @param array $classList
     * @return array
     */
    private function expandMergeClasses(array $classList)
    {
        $result = [];

        if (!empty($classList)) {
            foreach ($classList as $class) {
                if (!class_exists($class)) {
                    echo sprintf('----- Merge class `%s` not exists.', $class) . PHP_EOL;
                    continue;
                }

                $perms = (array)call_user_func([$class, 'get']);
                if (!empty($perms)) {
                    foreach ($perms as $perm => $desc) {
                        $result[$perm] = F::Permission($perm, $desc);
                    }
                }
            }
        }

        return $result;
    }
}