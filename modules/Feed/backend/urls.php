<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'GET feed/section/rest/sections/detail/<slug:[a-zA-Z0-9\-]+>' => 'feed/section/rest/section/detail',
    'GET feed/section/rest/sections/tree' => 'feed/section/rest/section/tree',

    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'feed/section/rest/section'],
    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'feed/item/rest/item'],
];