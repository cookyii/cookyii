<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'pages' => 'page/list/index',

    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'page/rest/page'],
];