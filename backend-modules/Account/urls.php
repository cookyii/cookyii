<?php
/**
 * urls.php
 * @author Revin Roman http://phptime.ru
 */

return [
    'account/auth/<authclient>' => 'account/sign/auth',
    'accounts' => 'account/list/index',

    ['class' => 'common\rest\UrlRule', 'controller' => 'account/rest/user']
];