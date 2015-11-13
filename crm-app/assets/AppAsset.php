<?php
/**
 * AppAsset.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace crm\assets;

/**
 * Class AppAsset
 * @package crm\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@base/crm-assets';

    public $css = [
        'css/styles.css',
    ];

    public $js = [
        'js/app.js',
        'js/functions.js',
        'js/scripts.js',
        'js/directives.js',
        'js/filters.js',
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

        'cookyii\assets\AnimateCssAssetBundle',
        'cookyii\assets\SweetAlertAssetBundle',
        'cookyii\assets\SpeakingurlAssetBundle',
        'cookyii\assets\MomentAssetBundle',
        'cookyii\assets\AdminLteAssetBundle',
        'cookyii\assets\angular\AngularAssetBundle',
        'cookyii\assets\angular\AngularMaterialAssetBundle',
        'cookyii\assets\jquery\DateTimePickerAssetBundle',
        'cookyii\assets\jquery\cdn\ScrollToAssetBundle',

        'crm\assets\ImperaviAssetBundle',
    ];
}