<?php
/**
 * FillAttributesAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\assets;

/**
 * Class FillAttributesAssetBundle
 * @package cookyii\modules\Account\frontend\assets
 */
class FillAttributesAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'styles.css',
    ];

    public $js = [
        'FillAttributesController.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/_sources';

        parent::init();
    }
}