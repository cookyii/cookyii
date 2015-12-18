<?php
/**
 * MouseWheelAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets\jquery;

/**
 * Class MouseWheelAssetBundle
 * @package common\_assets\jquery
 */
class MouseWheelAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'jquery-mousewheel/jquery.mousewheel.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}