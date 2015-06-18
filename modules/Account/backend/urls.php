<?php
/**
 * urls.php
 * @author Revin Roman
 */

return [
    'account/auth/<authclient>' => 'account/sign/auth',
    'accounts' => 'account/list/index',

    'POST account/rest/edit' => 'account/rest/user/edit',
    'POST account/rest/user-property' => 'account/rest/user-property/push',
    'PUT account/rest/roles' => 'account/rest/user/roles',
    'DELETE account/rest/user-property' => 'account/rest/user-property/delete',

    ['class' => 'common\rest\UrlRule', 'controller' => 'account/rest/user']
];