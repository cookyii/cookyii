<?php
/**
 * AngularAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\assets\angular\cdn;

/**
 * Class AngularAssetBundle
 * @package components\assets\angular\cdn
 */
class AngularAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        // angular official
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular-cookies.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular-loader.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular-resource.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular-sanitize.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular-aria.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular-animate.min.js',

        // angular material
        'https://ajax.googleapis.com/ajax/libs/angular_material/0.10.0/angular-material.min.js',

        // plugins
        'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap-tpls.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-utils/0.1.1/angular-ui-utils.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.7.1/loading-bar.min.js',
        'angular-elastic/elastic.js',
        'angular-truncate/src/truncate.js',
        'angular-redactor/angular-redactor.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}