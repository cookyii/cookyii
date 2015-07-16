<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'postman/templates' => 'postman/template/list',
    'postman/messages' => 'postman/message/list',

    'PUT postman/rest/messages/resent/<id:\d+>' => 'postman/rest/message/resent',

    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'postman/rest/template'],
    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'postman/rest/message'],
];