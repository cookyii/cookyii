<?php
/**
 * JScrollPaneAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\assets\jquery\cdn;

/**
 * Class JScrollPaneAssetBundle
 * @package cookyii\assets\jquery\cdn
 */
class JScrollPaneAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.12/jquery.mousewheel.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jScrollPane/2.0.14/jquery.jscrollpane.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}