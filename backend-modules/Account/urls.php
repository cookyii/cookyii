<?php
/**
 * urls.php
 * @author Revin Roman http://phptime.ru
 */

return [
    'account/auth/<authclient>' => 'account/sign/auth',
    'accounts' => 'account/list/index',

    'POST account/rest/edit' => 'account/rest/user/edit',
    'POST account/rest/user-property' => 'account/rest/user-property/push',
    'DELETE account/rest/user-property' => 'account/rest/user-property/delete',

    ['class' => 'common\rest\UrlRule', 'controller' => 'account/rest/user']
];