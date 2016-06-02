<?php
/**
 * Roles.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace common;

use rmrevin\yii\rbac\RbacFactory;

/**
 * Class Roles
 * @package common
 */
class Roles
{

    const USER = 'user';
    const CLIENT = 'client';
    const MANAGER = 'manager';
    const ADMIN = 'admin';

    /**
     * @return array
     */
    public static function getAllRoles()
    {
        return [
            RbacFactory::Role(Roles::ADMIN, 'Administrator'),
            RbacFactory::Role(Roles::MANAGER, 'Manager'),
            RbacFactory::Role(Roles::CLIENT, 'Client'),
            RbacFactory::Role(Roles::USER, 'User'),
        ];
    }
}