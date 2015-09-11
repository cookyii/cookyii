<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend;

/**
 * Class UrlRules
 * @package cookyii\modules\Account\frontend
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
            'account/forgot/check/<email>-<hash>' => 'account/forgot/check',
        ];
    }
}