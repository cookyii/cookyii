<?php
/**
 * Permissions.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm;

/**
 * Class Permissions
 * @package cookyii\modules\Client\crm
 */
class Permissions
{

    const ACCESS = 'crm.client.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::ACCESS => 'It has access to client crm module',
        ];
    }
}