<?php
/**
 * ImperaviAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace backend\assets;

/**
 * Class ImperaviAssetBundle
 * @package backend\assets
 */
class ImperaviAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@base/backend-assets';

    public $depends = [
        'rmrevin\yii\imperavi\AssetBundle',
        'rmrevin\yii\imperavi\plugins\FileManagerPluginAssetBundle',
        'rmrevin\yii\imperavi\plugins\ImageManagerPluginAssetBundle',
        'rmrevin\yii\imperavi\plugins\FullScreenPluginAssetBundle',
    ];
}