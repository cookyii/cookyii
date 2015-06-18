<?php
/**
 * IndexAssetBundle.php
 * @author Revin Roman
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
        'IndexController.js',
    ];

    public $depends = [
        'backend\_assets\AppAsset',
    ];
}