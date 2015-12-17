<?php
/**
 * SignUpAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\assets;

/**
 * Class SignUpAssetBundle
 * @package cookyii\modules\Account\frontend\assets
 */
class SignUpAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'styles.css',
    ];

    public $js = [
        'SignUpController.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}