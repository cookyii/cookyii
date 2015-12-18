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
        'iCheck/skins/all.css',
    ];

    public $js = [
        'iCheck/icheck.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}