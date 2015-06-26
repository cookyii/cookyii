<?php
/**
 * ImperaviAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace backend\assets;

/**
 * Class ImperaviAssetBundle
 * @package backend\assets
 */
class ImperaviAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/assets/_sources';

    public $depends = [
        'rmrevin\yii\fontawesome\cdn\AssetBundle',
        'rmrevin\yii\imperavi\AssetBundle',
        'rmrevin\yii\imperavi\plugins\FileManagerPluginAssetBundle',
        'rmrevin\yii\imperavi\plugins\ImageManagerPluginAssetBundle',
        'rmrevin\yii\imperavi\plugins\FullScreenPluginAssetBundle',
    ];
}