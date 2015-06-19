<?php
/**
 * Permissions.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\modules\Account\backend;

/**
 * Class Permissions
 * @package cookyii\modules\Account\backend
 */
class Permissions
{

    const ACCOUNT_ACCESS = 'backend.account.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::ACCOUNT_ACCESS => 'It has access to account backend module',
        ];
    }
}