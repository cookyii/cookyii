<?php
/**
 * AppAsset.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace crm\assets;

/**
 * Class AppAsset
 * @package crm\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@crm/assets/_sources';

    public $css = [
        'css/angular-material.css',
        'css/styles.css',
    ];

    public $js = [
        'js/app.js',
        'js/functions.js',
        'js/scripts.js',
        'js/directives.js',
        'js/CrmApp.js',
        'js/CrmApp/QueryScope.js',
        'js/CrmApp/ToastScope.js',
        'js/CrmApp/FilterSearchScope.js',
        'js/CrmApp/SortScope.js',
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
        'crm\assets\ImperaviAssetBundle',
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