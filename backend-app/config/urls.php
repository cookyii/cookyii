<?php
/**
 * urls.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

return [
    ['class' => \cookyii\modules\Account\backend\UrlRules::class],
    ['class' => \cookyii\modules\Page\backend\UrlRules::class],
    ['class' => \cookyii\modules\Feed\backend\UrlRules::class],
    ['class' => \cookyii\modules\Client\backend\UrlRules::class],
    ['class' => \cookyii\modules\Postman\backend\UrlRules::class],
    ['class' => \cookyii\modules\Translation\backend\UrlRules::class],
    '/dash' => 'dash/index'
];