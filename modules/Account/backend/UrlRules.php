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

            [
                'pattern' => 'account/rest/roles',
                'route' => 'account/rest/account/roles',
                'verb' => 'PUT',
            ], [
                'pattern' => 'account/rest/property',
                'route' => 'account/rest/property/push',
                'verb' => 'POST',
            ], [
                'pattern' => 'account/rest/property',
                'route' => 'account/rest/property/delete',
                'verb' => 'DELETE',
            ],

            [
                'class' => \cookyii\rest\UrlRule::className(),
                'controller' => 'account/rest/account',
            ],
        ];
    }
}