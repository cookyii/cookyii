<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Client\crm;

/**
 * Class UrlRules
 * @package cookyii\modules\Client\crm
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