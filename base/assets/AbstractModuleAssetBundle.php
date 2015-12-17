<?php
/**
 * AbstractModuleAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets;

/**
 * Class AbstractModuleAssetBundle
 * @package cookyii\assets
 */
abstract class AbstractModuleAssetBundle extends \yii\web\AssetBundle
{

    public $path;

    public $sourcePath;

    public function init()
    {
        $this->sourcePath = $this->path . '/_sources';

        parent::init();
    }
}