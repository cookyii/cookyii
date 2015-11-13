<?php
/**
 * AppAsset.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace frontend\assets;

/**
 * Class AppAsset
 * @package frontend\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@base/frontend-assets';

    public $css = [
        'css/styles.css',
    ];

    public $js = [
        'js/functions.js',
        'js/scripts.js',
        'js/filters.js',
        'js/FrontendApp.js',
        'js/FrontendApp/QueryScope.js',
        'js/FrontendApp/ToastScope.js',
    ];

    public $depends = [
        'cookyii\assets\Html5shivAssetBundle',
        'cookyii\assets\RespondAssetBundle',
        'cookyii\assets\ModernizrAssetBundle',

        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',

        'rmrevin\yii\fontawesome\cdn\AssetBundle',

        'cookyii\assets\AnimateCssAssetBundle',
        'cookyii\assets\SweetAlertAssetBundle',
        'cookyii\assets\angular\AngularAssetBundle',
        'cookyii\assets\angular\AngularMaterialAssetBundle',
        'cookyii\assets\jquery\ScrollToAssetBundle',
    ];
}