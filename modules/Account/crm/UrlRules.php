<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Account\crm;

/**
 * Class UrlRules
 * @package cookyii\modules\Account\crm
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
        ];
    }
}