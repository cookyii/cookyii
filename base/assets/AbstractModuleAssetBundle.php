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

    /**
     * @var string
     */
    public $path;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->sourcePath)) {
            $this->sourcePath = $this->path . '/_sources';
        }

        parent::init();
    }
}
