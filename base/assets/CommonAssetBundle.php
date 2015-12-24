<?php
/**
 * CommonAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets;

/**
 * Class CommonAssetBundle
 * @package cookyii\assets
 */
class CommonAssetBundle extends AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $js = [
        'js/functions.js',
        'js/directives.js',
        'js/filters.js',
        'js/scopes.js',
        'js/scopes/QueryScope.js',
        'js/scopes/ToastrScope.js',
        'js/scopes/SortScope.js',
        'js/scopes/FilterSearchScope.js',
        'js/third/angular-toastr.tpls.js',
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
        'cookyii\assets\MomentAssetBundle',
        'cookyii\assets\SpeakingUrlAssetBundle',
        'cookyii\assets\angular\AngularAssetBundle',
        'cookyii\assets\jquery\DateTimePickerAssetBundle',
        'cookyii\assets\jquery\ScrollToAssetBundle',
    ];
}