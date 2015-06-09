<?php
/**
 * ScrollToAssetBundle.php
 * @author Revin Roman
 */

namespace common\_assets\jquery;

/**
 * Class ScrollToAssetBundle
 * @package common\_assets\jquery
 */
class ScrollToAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}