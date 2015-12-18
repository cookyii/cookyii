<?php
/**
 * GI.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\helpers;

use yii\helpers\Html;

/**
 * Class GI glyph icon
 * @package cookyii\helpers
 */
class GI
{

    public static $cssPrefix = 'glyphicon';

    /**
     * @param string $name
     * @param array $options
     * @return string
     */
    public static function icon($name, $options = [])
    {
        Html::addCssClass($options, static::$cssPrefix);
        Html::addCssClass($options, static::$cssPrefix . '-' . $name);

        return Html::tag('span', null, $options);
    }
}