<?php
/**
 * EditAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\assets;

/**
 * Class EditAssetBundle
 * @package cookyii\modules\Account\backend\assets
 */
class EditAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'AccountResource.js',
        'DetailController.js',
        'EditController.js',
        'EditController/PropertiesController.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}