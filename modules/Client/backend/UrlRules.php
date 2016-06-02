<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\backend;

/**
 * Class UrlRules
 * @package cookyii\modules\Client\backend
 */
class UrlRules extends \cookyii\web\CompositeUrlRule
{

    /**
     * @return array
     */
    protected function getRules()
    {
        return [
            'clients' => 'client/list/index',

            [
                'pattern' => 'client/rest/create-account',
                'route' => 'client/rest/client/create-account',
                'verb' => 'POST',
            ],[
                'pattern' => 'client/rest/unlink-account',
                'route' => 'client/rest/client/unlink-account',
                'verb' => 'POST',
            ], [
                'pattern' => 'client/rest/property',
                'route' => 'client/rest/property/push',
                'verb' => 'POST',
            ], [
                'pattern' => 'client/rest/property',
                'route' => 'client/rest/property/delete',
                'verb' => 'DELETE',
            ],

            [
                'class' => \cookyii\rest\UrlRule::className(),
                'controller' => 'client/rest/client',
            ]
        ];
    }
}