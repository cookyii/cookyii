<?php
/**
 * Created by PhpStorm.
 * User: revin
 * Date: 16.12.14
 * Time: 18:41
 */

namespace common\_assets;

/**
 * Class AngularAssetBundle
 * @package common\_assets
 */
class AngularAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        // angular official
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-cookies.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-loader.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-sanitize.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-aria.min.js',
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-animate.min.js',

        // angular material
        'https://ajax.googleapis.com/ajax/libs/angular_material/0.9.0/angular-material.min.js',

        // plugins
        'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap-tpls.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-utils/0.1.1/angular-ui-utils.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.7.1/loading-bar.min.js',
        'angular-elastic/elastic.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}