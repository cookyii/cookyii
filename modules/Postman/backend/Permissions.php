<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend;

/**
 * Class Permissions
 * @package cookyii\modules\Postman\backend
 */
class Permissions
{

    const ACCESS = 'backend.postman.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::ACCESS => 'It has access to postman backend module',
        ];
    }
}