<?php
/**
 * AdminLteAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets;

/**
 * Class AdminLteAssetBundle
 * @package cookyii\assets
 */
class AdminLteAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'admin-lte/dist/js/app.min.js',
    ];

    public $css = [
        'admin-lte/dist/css/AdminLTE.min.css',
        'admin-lte/dist/css/skins/_all-skins.min.css',
    ];
}