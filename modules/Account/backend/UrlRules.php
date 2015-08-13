<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Account\backend;

/**
 * Class UrlRules
 * @package cookyii\modules\Account\backend
 */
class UrlRules extends \cookyii\web\CompositeUrlRule
{

    /**
     * @return array
     */
    protected function getRules()
    {
        return [
            'account/auth/<authclient>' => 'account/sign/auth',
            'accounts' => 'account/list/index',

            'PUT account/rest/roles' => 'account/rest/account/roles',
            'POST account/rest/property' => 'account/rest/property/push',
            'DELETE account/rest/property' => 'account/rest/property/delete',

            [
                'class' => \cookyii\rest\UrlRule::className(),
                'controller' => 'account/rest/account',
            ],
        ];
    }
}