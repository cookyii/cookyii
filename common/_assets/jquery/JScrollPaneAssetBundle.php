<?php
/**
 * JScrollPaneAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\_assets\jquery;

/**
 * Class JScrollPaneAssetBundle
 * @package common\_assets\jquery
 */
class JScrollPaneAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'jscrollpane/script/jquery.mousewheel.js',
        'jscrollpane/script/jquery.jscrollpane.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}