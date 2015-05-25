<?php
/**
 * Html5shivAssetBundle.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\_assets;

/**
 * Class Html5shivAssetBundle
 * @package common\_assets
 */
class Html5shivAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js',
    ];

    public $jsOptions = [
        'condition' => 'lt IE 9',
    ];
}