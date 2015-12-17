<?php
/**
 * SignInAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\assets;

/**
 * Class SignInAssetBundle
 * @package cookyii\modules\Account\frontend\assets
 */
class SignInAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'styles.css',
    ];

    public $js = [
        'SignInController.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}