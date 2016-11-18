<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\backend;

use cookyii\rest\UrlRule;

/**
 * Class UrlRules
 * @package cookyii\modules\Page\backend
 */
class UrlRules extends \cookyii\web\CompositeUrlRule
{

    /**
     * @return array
     */
    protected function getRules()
    {
        return [
            'pages' => 'page/list/index',

            [
                'class' => UrlRule::class,
                'controller' => 'page/rest/page',
            ],
        ];
    }
}