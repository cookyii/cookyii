<?php
/**
 * Roles.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace common;

use cookyii\interfaces\RolesDictInterface;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class Roles
 * @package common
 */
class Roles implements RolesDictInterface
{

    const USER = 'user';
    const CLIENT = 'client';
    const MANAGER = 'manager';
    const ADMIN = 'admin';

    /**
     * @inheritdoc
     */
    public static function get()
    {
        return [
            RbacFactory::Role(static::ADMIN, 'Administrator'),
            RbacFactory::Role(static::MANAGER, 'Manager'),
            RbacFactory::Role(static::CLIENT, 'Client'),
            RbacFactory::Role(static::USER, 'User'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function inheritance()
    {
        return [
            static::ADMIN => [
                static::MANAGER,
            ],
            static::MANAGER => [
                static::USER,
            ],
            static::CLIENT => [
                static::USER,
            ],
            static::USER => [],
        ];
    }
}