<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\backend;

use cookyii\interfaces\PermissionsModuleDictInterface;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class Permissions
 * @package cookyii\modules\Page\backend
 */
class Permissions implements PermissionsModuleDictInterface
{

    const ACCESS = 'backend.page.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            RbacFactory::Permission(static::ACCESS, 'It has access to page backend module'),
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
