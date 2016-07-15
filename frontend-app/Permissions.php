<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace frontend;

use common\Roles;
use cookyii\interfaces\PermissionsDictInterface;
use cookyii\modules\Page\frontend\Permissions as Page;
use cookyii\rbac\AbstractPermissionsDict;
use frontend\Permissions as Frontend;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class Permissions
 * @package frontend
 */
class Permissions extends AbstractPermissionsDict implements PermissionsDictInterface
{

    const ACCESS = 'frontend.access';

    /**
     * @var array
     */
    static $merge = [
        Page::class,
    ];

    /**
     * @inheritdoc
     */
    public static function get()
    {
        return array_merge(
            [
                RbacFactory::Permission(static::ACCESS, 'It has access to the frontend'),
            ],
            static::expandPermissions(static::$merge)
        );
    }

    /**
     * @inheritdoc
     */
    public static function rules()
    {
        return array_merge(
            [],
            static::expandRules(static::$merge)
        );
    }

    /**
     * @inheritdoc
     */
    public static function inheritance()
    {
        return [
            Roles::ADMIN => [],
            Roles::MANAGER => [],
            Roles::CLIENT => [],
            Roles::USER => [
                Frontend::ACCESS,
                Page::ACCESS,
            ],
        ];
    }
}
