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

            'POST client/rest/property' => 'client/rest/property/push',
            'DELETE client/rest/property' => 'client/rest/property/delete',

            ['class' => \cookyii\rest\UrlRule::className(), 'controller' => 'client/rest/client']
        ];
    }
}