<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend;

/**
 * Class Permissions
 * @package cookyii\modules\Feed\backend
 */
class Permissions
{

    const ACCESS = 'backend.feed.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::ACCESS => 'It has access to feed backend module',
        ];
    }
}