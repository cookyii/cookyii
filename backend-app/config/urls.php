<?php
/**
 * urls.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

return [
    ['class' => \cookyii\modules\Account\backend\UrlRules::className()],
    ['class' => \cookyii\modules\Page\backend\UrlRules::className()],
    ['class' => \cookyii\modules\Feed\backend\UrlRules::className()],
    ['class' => \cookyii\modules\Postman\backend\UrlRules::className()],
    ['class' => \cookyii\modules\Translation\backend\UrlRules::className()],
    '/dash' => 'dash/index'
];