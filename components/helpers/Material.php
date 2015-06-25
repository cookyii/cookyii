<?php
/**
 * Material.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\helpers;

/**
 * Class Material
 * @package components\helpers
 */
class Material extends \yii\helpers\Html
{

    /**
     * @inheritdoc
     */
    public static $dataAttributes = ['data', 'data-ng', 'ng', 'md'];

    /**
     * @param string $content
     * @param array $options
     * @return string
     */
    public static function tooltip($content = 'Tooltip', $options = [])
    {
        return static::tag('md-tooltip', $content, $options);
    }

    /**
     * @inheritdoc
     */
    public static function button($content = 'Button', $options = [])
    {
        return static::tag('md-button', $content, $options);
    }
}