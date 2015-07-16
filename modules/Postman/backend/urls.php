<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'postman/templates' => 'postman/template/list',
    'postman/messages' => 'postman/message/list',

    'POST postman/rest/template/edit' => 'postman/rest/template/edit',
    'POST postman/rest/message/edit' => 'postman/rest/message/edit',

    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'postman/rest/template'],
    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'postman/rest/message'],
];