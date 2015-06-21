<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'postman/templates' => 'postman/template/list',

    'POST postman/rest/template/edit' => 'postman/rest/template/edit',

    ['class' => components\rest\UrlRule::className(), 'controller' => 'postman/rest/template']
];