<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\backend;

use cookyii\interfaces\PermissionsModuleDictInterface;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class Permissions
 * @package cookyii\modules\Client\backend
 */
class Permissions implements PermissionsModuleDictInterface
{

    const ACCESS = 'backend.client.access';

    /**
     * @inheritdoc
     */
    public static function get()
    {
        return [
            RbacFactory::Permission(static::ACCESS, 'It has access to client backend module'),
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
