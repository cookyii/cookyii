<?php
/**
 * AngularAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets\angular;

/**
 * Class AngularAssetBundle
 * @package cookyii\assets\angular
 */
class AngularAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        // angular official
        'angular/angular.js',
        'angular-cookies/angular-cookies.min.js',
        'angular-loader/angular-loader.min.js',
        'angular-resource/angular-resource.min.js',
        'angular-sanitize/angular-sanitize.min.js',
        'angular-aria/angular-aria.min.js',
        'angular-animate/angular-animate.min.js',

        // plugins
        'angular-bootstrap/ui-bootstrap-tpls.min.js',
        'angular-ui-utils/ui-utils.min.js',
        'angular-loading-bar/build/loading-bar.min.js',
        'angular-elastic/elastic.js',
        'angular-redactor/angular-redactor.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'cookyii\assets\jquery\JScrollPaneAssetBundle',
    ];
}