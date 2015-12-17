<?php
/**
 * ForgotPasswordAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\assets;

/**
 * Class ForgotPasswordAssetBundle
 * @package cookyii\modules\Account\frontend\assets
 */
class ForgotPasswordAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'styles.css',
    ];

    public $js = [
        'ForgotPasswordController.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}