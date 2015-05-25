<?php
/**
 * JScrollPaneAssetBundle.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\_assets\jquery;

/**
 * Class JScrollPaneAssetBundle
 * @package common\_assets\jquery
 */
class JScrollPaneAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.12/jquery.mousewheel.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jScrollPane/2.0.14/jquery.jscrollpane.min.js',
    ];

    public $depends = [
        \yii\web\JqueryAsset::class,
    ];
}