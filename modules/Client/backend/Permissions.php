<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\backend;

/**
 * Class Permissions
 * @package cookyii\modules\Client\backend
 */
class Permissions
{

    const ACCESS = 'backend.client.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::ACCESS => 'It has access to client backend module',
        ];
    }
}