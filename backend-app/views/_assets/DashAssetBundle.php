<?php
/**
 * IndexAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace backend\views\_assets;

/**
 * Class DashAssetBundle
 * @package backend\views\site\_assets
 */
class DashAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/views/_assets/_sources';

    public $css = [
        'dash.css',
    ];

    public $js = [
        'DashController.js',
    ];

    public $depends = [
        'backend\_assets\AppAsset',
    ];
}