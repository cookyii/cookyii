<?php
/**
 * Permissions.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Translation\backend;

/**
 * Class Permissions
 * @package namespace cookyii\modules\Translation\backend
 */
class Permissions
{

    const ACCESS = 'backend.translation.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::ACCESS => 'It has access to translation backend module',
        ];
    }
}