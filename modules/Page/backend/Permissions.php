<?php
/**
 * Permissions.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\modules\Page\backend;

/**
 * Class Permissions
 * @package cookyii\modules\Page\backend
 */
class Permissions
{

    const PAGE_ACCESS = 'backend.page.access';

    /**
     * @return array
     */
    public static function get()
    {
        return [
            static::PAGE_ACCESS => 'It has access to page backend module',
        ];
    }
}