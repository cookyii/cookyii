<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend;

use cookyii\interfaces\PermissionsModuleDictInterface;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class Permissions
 * @package cookyii\modules\Account\backend
 */
class Permissions implements PermissionsModuleDictInterface
{

    const ACCESS = 'backend.account.access';

    /**
     * @inheritdoc
     */
    public static function get()
    {
        return [
            RbacFactory::Permission(static::ACCESS, 'It has access to account backend module'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function rules()
    {
        return [];
    }
}
