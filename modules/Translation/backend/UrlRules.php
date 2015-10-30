<?php
/**
 * UrlRules.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Translation\backend;

/**
 * Class UrlRules
 * @package cookyii\modules\Translation\backend
 */
class UrlRules extends \cookyii\web\CompositeUrlRule
{

    /**
     * @return array
     */
    protected function getRules()
    {
        return [
            'translations' => 'translation/list/index',
        ];
    }
}