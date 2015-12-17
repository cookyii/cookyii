<?php
/**
 * EditSectionAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\assets;

/**
 * Class EditSectionAssetBundle
 * @package cookyii\modules\Feed\backend\assets
 */
class EditSectionAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'SectionDropdownScope.js',
        'SectionResource.js',
        'SectionDetailController.js',
        'SectionEditController.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}