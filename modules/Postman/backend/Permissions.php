<?php
/**
 * Permissions.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\modules\Postman\backend;

/**
 * Class Permissions
 * @package cookyii\modules\Postman\backend
 */
class Permissions
{

    const POSTMAN_ACCESS = 'backend.postman.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::POSTMAN_ACCESS => 'It has access to postman backend module',
        ];
    }
}