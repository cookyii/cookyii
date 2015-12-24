<?php
/**
 * ICheckAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets\jquery;

/**
 * Class ICheckAssetBundle
 * @package cookyii\assets\jquery
 */
class ICheckAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $css = [
        'icheck/skins/square/_all.css',
    ];

    public $js = [
        'icheck/icheck.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}