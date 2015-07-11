<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'pages' => 'page/list/index',

    'POST page/rest/edit' => 'page/rest/page/edit',

    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'page/rest/page'],
];