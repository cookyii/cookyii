<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Feed\backend\assets
 */
class ListAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'list.css',
    ];

    public $js = [
        'SectionResource.js',
        'ItemResource.js',
        'ListController.js',
        'ListController/FilterScope.js',
        'ListController/FilterSectionScope.js',
        'ListController/ItemListScope.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}