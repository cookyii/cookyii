<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\frontend;

use cookyii\interfaces\PermissionsModuleDictInterface;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class Permissions
 * @package cookyii\modules\Page\frontend
 */
class Permissions implements PermissionsModuleDictInterface
{

    const ACCESS = 'frontend.page.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            RbacFactory::Permission(static::ACCESS, 'It has access to page frontend module'),
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
