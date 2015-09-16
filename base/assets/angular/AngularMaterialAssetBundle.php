<?php
/**
 * AngularMaterialAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets\angular;

/**
 * Class AngularMaterialAssetBundle
 * @package cookyii\assets\angular
 */
class AngularMaterialAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $css = [
        'angular-material/angular-material.min.css'
    ];

    public $js = [
        'angular-aria/angular-aria.min.js',
        'angular-animate/angular-animate.min.js',
        'angular-material/angular-material.min.js'
    ];

    public $depends = [
        'cookyii\assets\angular\AngularAssetBundle',
    ];
}