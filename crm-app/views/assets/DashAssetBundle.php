<?php
/**
 * IndexAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace crm\views\assets;

/**
 * Class DashAssetBundle
 * @package crm\views\site\assets
 */
class DashAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@crm/views/assets/_sources';

    public $css = [
        'dash.css',
    ];

    public $js = [
        'DashController.js',
    ];

    public $depends = [
        'crm\assets\AppAsset',
    ];
}