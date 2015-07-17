<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'clients' => 'client/list/index',

    'POST client/rest/property' => 'client/rest/property/push',
    'DELETE client/rest/property' => 'client/rest/property/delete',

    ['class' => cookyii\rest\UrlRule::className(), 'controller' => 'client/rest/client']
];