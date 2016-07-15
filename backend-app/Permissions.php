<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace backend;

use backend\Permissions as Backend;
use common\Roles;
use cookyii\interfaces\PermissionsDictInterface;
use cookyii\modules\Account\backend\Permissions as Account;
use cookyii\modules\Client\backend\Permissions as Client;
use cookyii\modules\Feed\backend\Permissions as Feed;
use cookyii\modules\Page\backend\Permissions as Page;
use cookyii\modules\Postman\backend\Permissions as Postman;
use cookyii\modules\Translation\backend\Permissions as Translation;
use cookyii\rbac\AbstractPermissionsDict;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class Permissions
 * @package backend
 */
class Permissions extends AbstractPermissionsDict implements PermissionsDictInterface
{

    const ACCESS = 'backend.access';

    /** @var array */
    static $merge = [
        Account::class,
        Feed::class,
        Client::class,
        Page::class,
        Postman::class,
        Translation::class,
    ];

    /**
     * @inheritdoc
     */
    public static function get()
    {
        return array_merge(
            [
                RbacFactory::Permission(static::ACCESS, 'It has access to the backend'),
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
            Roles::ADMIN => [
                Account::ACCESS,
            ],
            Roles::MANAGER => [
                Backend::ACCESS,
                Client::ACCESS,
                Page::ACCESS,
                Translation::ACCESS,
                Postman::ACCESS,
                Feed::ACCESS,
            ],
            Roles::CLIENT => [],
            Roles::USER => [],
        ];
    }
}
