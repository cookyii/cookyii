<?php
/**
 * AppAsset.php
 * @author Revin Roman
 */

namespace backend\_assets;

/**
 * Class AppAsset
 * @package backend\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/_assets/_sources';

    public $css = [
        'css/angular-material.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'css/styles.css',
    ];

    public $js = [
        'js/app.js',
        'js/functions.js',
        'js/scripts.js',
        'js/BackendApp.js',
    ];

    public $depends = [
        'common\_assets\Html5shivAssetBundle',
        'common\_assets\RespondAssetBundle',
        'common\_assets\ModernizrAssetBundle',

        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\CDNAssetBundle',
        'common\_assets\AnimateCssAssetBundle',
        'common\_assets\SweetAlertAssetBundle',
        'common\_assets\AngularAssetBundle',
        'common\_assets\jquery\FormAssetBundle',
        'common\_assets\jquery\ScrollToAssetBundle',
        'common\_assets\jquery\JScrollPaneAssetBundle',
    ];
}