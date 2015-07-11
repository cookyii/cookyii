<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'postman/templates' => 'postman/template/list',

    'POST postman/rest/template/edit' => 'postman/rest/template/edit',

    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'postman/rest/template']
];