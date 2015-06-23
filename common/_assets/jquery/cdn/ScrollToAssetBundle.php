<?php
/**
 * ScrollToAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\_assets\jquery\cdn;

/**
 * Class ScrollToAssetBundle
 * @package common\_assets\jquery\cdn
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