<?php
/**
 * IndexAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace backend\views\assets;

/**
 * Class DashAssetBundle
 * @package backend\views\site\assets
 */
class DashAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/views/assets/_sources';

    public $css = [
        'dash.css',
    ];

    public $js = [
        'DashController.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}