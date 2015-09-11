<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend;

/**
 * Class UrlRules
 * @package cookyii\modules\Postman\backend
 */
class UrlRules extends \cookyii\web\CompositeUrlRule
{

    /**
     * @return array
     */
    protected function getRules()
    {
        return [
            'postman/templates' => 'postman/template/list',
            'postman/messages' => 'postman/message/list',

            'PUT postman/rest/messages/resent/<id:\d+>' => 'postman/rest/message/resent',

            ['class' => \cookyii\rest\UrlRule::className(), 'controller' => 'postman/rest/template'],
            ['class' => \cookyii\rest\UrlRule::className(), 'controller' => 'postman/rest/message'],
        ];
    }
}