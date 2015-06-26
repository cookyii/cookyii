<?php
/**
 * AppAsset.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace frontend\assets;

/**
 * Class AppAsset
 * @package frontend\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@frontend/assets/_sources';

    public $css = [
        'css/angular-material.css',
        'css/styles.css',
    ];

    public $js = [
        'js/functions.js',
        'js/scripts.js',
        'js/FrontendApp.js',
    ];

    public $depends = [
        'components\assets\Html5shivAssetBundle',
        'components\assets\RespondAssetBundle',
        'components\assets\ModernizrAssetBundle',

        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\cdn\AssetBundle',
        'components\assets\AnimateCssAssetBundle',
        'components\assets\SweetAlertAssetBundle',
        'components\assets\angular\AngularAssetBundle',
        'components\assets\jquery\FormAssetBundle',
        'components\assets\jquery\ScrollToAssetBundle',
        'components\assets\jquery\JScrollPaneAssetBundle',
    ];
}