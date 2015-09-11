<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Feed\backend;

/**
 * Class UrlRules
 * @package cookyii\modules\Feed\backend
 */
class UrlRules extends \cookyii\web\CompositeUrlRule
{

    /**
     * @return array
     */
    protected function getRules()
    {
        return [
            'feed/section/rest/sections/detail/<slug:[a-zA-Z0-9\-]+>' => 'feed/section/rest/section/detail',
            'feed/section/rest/sections/tree' => 'feed/section/rest/section/tree',

            [
                'class' => \cookyii\rest\UrlRule::className(),
                'controller' => 'feed/section/rest/section',
            ], [
                'class' => \cookyii\rest\UrlRule::className(),
                'controller' => 'feed/item/rest/item',
            ],
        ];
    }
}