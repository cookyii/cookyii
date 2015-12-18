<?php
/**
 * AppAsset.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace crm\assets;

/**
 * Class AppAsset
 * @package crm\assets
 */
class AppAsset extends \yii\web\AssetBundle
{

    public $sourcePath = '@base/crm-assets';

    public $css = [
        '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&subset=latin,cyrillic',
        'css/styles.css',
    ];

    public $js = [
        'js/CrmApp.js',
    ];

    public $depends = [
        'common\assets\CommonAssetBundle',

        'cookyii\assets\AdminLteAssetBundle',
        'cookyii\assets\jquery\ICheckAssetBundle',
        'cookyii\assets\angular\AngularAssetBundle',
        'cookyii\assets\angular\AngularMaterialAssetBundle',

        'crm\assets\ImperaviAssetBundle',
    ];
}