<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'account/auth/<authclient>' => 'account/sign/auth',
    'accounts' => 'account/list/index',

    'PUT account/rest/roles' => 'account/rest/account/roles',
    'POST account/rest/edit' => 'account/rest/account/edit',
    'POST account/rest/property' => 'account/rest/property/push',
    'DELETE account/rest/property' => 'account/rest/property/delete',

    ['class' => components\rest\UrlRule::className(), 'controller' => 'account/rest/account']
];