<?php
/**
 * EditItemAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\assets;

/**
 * Class EditItemAssetBundle
 * @package cookyii\modules\Feed\backend\assets
 */
class EditItemAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'SectionDropdownScope.js',
        'SectionResource.js',
        'ItemResource.js',
        'ItemDetailController.js',
        'ItemEditController.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}