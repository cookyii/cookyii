<?php
/**
 * CommonAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace common\assets;

/**
 * Class CommonAssetBundle
 * @package common\assets
 */
class CommonAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@base/common-assets';

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
        'cookyii\assets\jquery\DateTimePickerAssetBundle',
        'cookyii\assets\jquery\ScrollToAssetBundle',
    ];
}