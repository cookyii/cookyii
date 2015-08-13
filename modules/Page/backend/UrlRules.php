<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Page\backend;

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

            ['class' => \cookyii\rest\UrlRule::className(), 'controller' => 'page/rest/page'],
        ];
    }
}