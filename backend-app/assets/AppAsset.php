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
        'css/styles.css',
    ];

    public $js = [
        'js/functions.js',
        'js/scripts.js',
        'js/directives.js',
        'js/filters.js',
        'js/BackendApp.js',
        'js/BackendApp/QueryScope.js',
        'js/BackendApp/ToastScope.js',
        'js/BackendApp/FilterSearchScope.js',
        'js/BackendApp/SortScope.js',
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

        'cookyii\assets\AdminLteAssetBundle',
        'cookyii\assets\AnimateCssAssetBundle',
        'cookyii\assets\SweetAlertAssetBundle',
        'cookyii\assets\MomentAssetBundle',
        'cookyii\assets\angular\AngularAssetBundle',
        'cookyii\assets\angular\AngularMaterialAssetBundle',
        'cookyii\assets\jquery\DateTimePickerAssetBundle',
        'cookyii\assets\jquery\cdn\ScrollToAssetBundle',

        'backend\assets\ImperaviAssetBundle',
    ];
}