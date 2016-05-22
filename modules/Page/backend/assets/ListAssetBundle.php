<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\backend\assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Page\backend\assets
 */
class ListAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'list.css',
    ];

    public $js = [
        'PageResource.js',
        'ListController.js',
        'ListController/FilterScope.js',
        'ListController/ListScope.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}