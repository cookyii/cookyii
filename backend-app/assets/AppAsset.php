<?php
/**
 * AppAsset.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace backend\assets;

/**
 * Class AppAsset
 * @package backend\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/assets/_sources';

    public $css = [
        'css/angular-material.css',
        'css/styles.css',
    ];

    public $js = [
        'js/app.js',
        'js/functions.js',
        'js/scripts.js',
        'js/directives.js',
        'js/BackendApp.js',
        'js/scopes/QueryScope.js',
        'js/scopes/ToastScope.js',
        'js/scopes/FilterSearchScope.js',
        'js/scopes/SortScope.js',
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
        'backend\assets\ImperaviAssetBundle',
        'cookyii\assets\AnimateCssAssetBundle',
        'cookyii\assets\SweetAlertAssetBundle',
        'cookyii\assets\SpeakingurlAssetBundle',
        'cookyii\assets\MomentAssetBundle',
        'cookyii\assets\angular\AngularAssetBundle',
        'cookyii\assets\jquery\DateTimePickerAssetBundle',
        'cookyii\assets\jquery\cdn\FormAssetBundle',
        'cookyii\assets\jquery\cdn\ScrollToAssetBundle',
        'cookyii\assets\jquery\cdn\JScrollPaneAssetBundle',
    ];
}