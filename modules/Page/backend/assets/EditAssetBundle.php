<?php
/**
 * EditAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\backend\assets;

/**
 * Class EditAssetBundle
 * @package cookyii\modules\Page\backend\assets
 */
class EditAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'PageResource.js',
        'DetailController.js',
        'EditController.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}