<?php
/**
 * ImperaviAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace crm\assets;

/**
 * Class ImperaviAssetBundle
 * @package crm\assets
 */
class ImperaviAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@crm/assets/_sources';

    public $depends = [
        'rmrevin\yii\fontawesome\cdn\AssetBundle',
        'rmrevin\yii\imperavi\AssetBundle',
        'rmrevin\yii\imperavi\plugins\FileManagerPluginAssetBundle',
        'rmrevin\yii\imperavi\plugins\ImageManagerPluginAssetBundle',
        'rmrevin\yii\imperavi\plugins\FullScreenPluginAssetBundle',
    ];
}