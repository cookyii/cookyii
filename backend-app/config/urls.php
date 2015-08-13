<?php
/**
 * urls.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

return [
    ['class' => \cookyii\modules\Account\backend\UrlRules::className()],
    ['class' => \cookyii\modules\Page\backend\UrlRules::className()],
    ['class' => \cookyii\modules\Feed\backend\UrlRules::className()],
    ['class' => \cookyii\modules\Postman\backend\UrlRules::className()],
    '/dash' => 'dash/index'
];