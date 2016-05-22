<?php
/**
 * EditAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\assets;

/**
 * Class EditAssetBundle
 * @package cookyii\modules\Client\crm\assets
 */
class EditAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'ClientResource.js',
        'DetailController.js',
        'EditController.js',
        'EditController/AccountScope.js',
        'EditController/PropertiesController.js',
    ];

    public $depends = [
        'crm\assets\AppAsset',
    ];
}