<?php
/**
 * Permissions.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\modules\Account\crm;

/**
 * Class Permissions
 * @package cookyii\modules\Account\crm
 */
class Permissions
{

    const ACCESS = 'crm.account.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::ACCESS => 'It has access to account crm module',
        ];
    }
}