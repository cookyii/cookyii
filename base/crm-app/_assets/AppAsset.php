<?php
/**
 * AppAsset.php
 * @author Revin Roman http://phptime.ru
 */

namespace crm\_assets;

/**
 * Class AppAsset
 * @package crm\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@crm/_assets/_sources';

    public $css = [
        'css/angular-material.css',
        'css/styles-less.css',
        'css/styles-sass.css',
        'css/styles-stylus.css',
    ];

    public $js = [
        'js/functions.js',
        'js/scripts.js',
        'js/CrmApp.js',
    ];

    public $depends = [
        \common\_assets\Html5shivAssetBundle::class,
        \common\_assets\RespondAssetBundle::class,
        \common\_assets\ModernizrAssetBundle::class,

        \yii\web\YiiAsset::class,
        \yii\web\JqueryAsset::class,
        \yii\bootstrap\BootstrapAsset::class,
        \yii\bootstrap\BootstrapPluginAsset::class,
        \rmrevin\yii\fontawesome\CDNAssetBundle::class,
        \common\_assets\AnimateCssAssetBundle::class,
        \common\_assets\SweetAlertAssetBundle::class,
        \common\_assets\AngularAssetBundle::class,
        \common\_assets\jquery\FormAssetBundle::class,
        \common\_assets\jquery\ScrollToAssetBundle::class,
        \common\_assets\jquery\JScrollPaneAssetBundle::class,
    ];
}