<?php
/**
 * AppAsset.php
 * @author Revin Roman
 * @link https://rmrevin.ru
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
        'css/styles.css',
    ];

    public $js = [
        'js/app.js',
        'js/functions.js',
        'js/scripts.js',
        'js/directives.js',
        'js/BackendApp.js',
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
        'rmrevin\yii\imperavi\AssetBundle',
        'rmrevin\yii\imperavi\plugins\FileManagerPluginAssetBundle',
        'rmrevin\yii\imperavi\plugins\ImageManagerPluginAssetBundle',
        'rmrevin\yii\imperavi\plugins\FullScreenPluginAssetBundle',
        'components\assets\AnimateCssAssetBundle',
        'components\assets\SweetAlertAssetBundle',
        'components\assets\SpeakingurlAssetBundle',
        'components\assets\MomentAssetBundle',
        'components\assets\angular\AngularAssetBundle',
        'components\assets\jquery\DateTimePickerAssetBundle',
        'components\assets\jquery\cdn\FormAssetBundle',
        'components\assets\jquery\cdn\ScrollToAssetBundle',
        'components\assets\jquery\cdn\JScrollPaneAssetBundle',
    ];
}