<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'GET feed/section/rest/sections/detail/<slug:[a-zA-Z0-9\-]+>' => 'feed/section/rest/section/detail',
    'GET feed/section/rest/sections/tree' => 'feed/section/rest/section/tree',

    'POST feed/section/rest/edit' => 'feed/section/rest/section/edit',
    'POST feed/item/rest/edit' => 'feed/item/rest/item/edit',

    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'feed/section/rest/section'],
    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'feed/item/rest/item'],
];