<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\frontend;

/**
 * Class UrlRules
 * @package cookyii\modules\Page\frontend
 */
class UrlRules extends \cookyii\web\CompositeUrlRule
{

    /**
     * @return array
     */
    protected function getRules()
    {
        return [
            'page/<slug>' => 'page',
        ];
    }
}