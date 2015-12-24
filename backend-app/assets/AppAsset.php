<?php
/**
 * AppAsset.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace backend\assets;

/**
 * Class AppAsset
 * @package backend\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@base/backend-assets';

    public $css = [
        '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&subset=latin,cyrillic',
        'css/styles.css',
    ];

    public $js = [
        'js/BackendApp.js',
    ];

    public $depends = [
        'cookyii\assets\CommonAssetBundle',

        'cookyii\assets\AdminLteAssetBundle',
        'cookyii\assets\jquery\ICheckAssetBundle',
        'cookyii\assets\angular\AngularMaterialAssetBundle',

        'backend\assets\ImperaviAssetBundle',
    ];
}