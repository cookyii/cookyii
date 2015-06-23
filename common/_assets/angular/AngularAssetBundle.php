<?php
/**
 * AngularAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\_assets\angular;

/**
 * Class AngularAssetBundle
 * @package common\_assets\angular
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

        // angular material
        'angular-material/angular-material.min.js',

        // plugins
        'angular-bootstrap/ui-bootstrap-tpls.min.js',
        'angular-ui-utils/ui-utils.min.js',
        'angular-loading-bar/build/loading-bar.min.js',
        'angular-elastic/elastic.js',
        'angular-truncate/src/truncate.js',
        'angular-redactor/angular-redactor.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}