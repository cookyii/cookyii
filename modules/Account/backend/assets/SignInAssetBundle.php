<?php
/**
 * SignInAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\assets;

/**
 * Class SignInAssetBundle
 * @package cookyii\modules\Account\backend\assets
 */
class SignInAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'signin.css',
    ];

    public $js = [
        'SignInController.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}