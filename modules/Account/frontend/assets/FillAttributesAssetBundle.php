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
class FillAttributesAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'styles.css',
    ];

    public $js = [
        'FillAttributesController.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}