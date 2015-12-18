<?php
/**
 * AppAsset.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace frontend\assets;

/**
 * Class AppAsset
 * @package frontend\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@base/frontend-assets';

    public $css = [
        '//fonts.googleapis.com/css?family=Open+Sans:200,400,700&subset=latin,cyrillic',
        'css/styles.css',
    ];

    public $js = [
        'js/FrontendApp.js',
    ];

    public $depends = [
        'common\assets\CommonAssetBundle',

        'cookyii\assets\angular\AngularAssetBundle',
    ];
}