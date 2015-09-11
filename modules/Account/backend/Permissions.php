<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend;

/**
 * Class Permissions
 * @package cookyii\modules\Account\backend
 */
class Permissions
{

    const ACCESS = 'backend.account.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::ACCESS => 'It has access to account backend module',
        ];
    }
}