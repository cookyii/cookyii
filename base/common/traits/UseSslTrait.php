<?php
/**
 * UseSslTrait.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\traits;

/**
 * Trait UseSslTrait
 * @package common\traits
 */
trait UseSslTrait
{

    /**
     * @param bool $send_redirect
     * @return bool
     */
    public function checkUseSsl($send_redirect = false)
    {
        $redirect = true === USE_SSL && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on');

        if (true === $send_redirect) {
            if (true === $redirect) {
                Response()
                    ->redirect('https://' . Request()->serverName . Request()->url)
                    ->send();
                exit;
            }
        }

        return $redirect;
    }
}