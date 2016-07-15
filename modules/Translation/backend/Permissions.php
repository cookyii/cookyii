<?php
/**
 * Permissions.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Translation\backend;

use cookyii\interfaces\PermissionsModuleDictInterface;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class Permissions
 * @package namespace cookyii\modules\Translation\backend
 */
class Permissions implements PermissionsModuleDictInterface
{

    const ACCESS = 'backend.translation.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            RbacFactory::Permission(static::ACCESS, 'It has access to translation backend module'),
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
