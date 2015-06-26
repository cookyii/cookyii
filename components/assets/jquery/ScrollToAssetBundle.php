<?php
/**
 * ScrollToAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\assets\jquery;

/**
 * Class ScrollToAssetBundle
 * @package components\assets\jquery
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