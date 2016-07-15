<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend;

use cookyii\interfaces\PermissionsModuleDictInterface;

/**
 * Class Permissions
 * @package cookyii\modules\Account\frontend
 */
class Permissions implements PermissionsModuleDictInterface
{

    /**
     * @inheritdoc
     */
    public static function get()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function rules()
    {
        return [];
    }
}
