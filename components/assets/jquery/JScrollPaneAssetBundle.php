<?php
/**
 * JScrollPaneAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\assets\jquery;

/**
 * Class JScrollPaneAssetBundle
 * @package components\assets\jquery
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