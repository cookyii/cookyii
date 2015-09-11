<?php
/**
 * ScrollToAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\assets\jquery;

/**
 * Class ScrollToAssetBundle
 * @package cookyii\assets\jquery
 */
class ScrollToAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'jquery.scrollTo/jquery.scrollTo.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}