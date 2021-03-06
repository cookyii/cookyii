<?php
/**
 * ListAssetBundle.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Translation\backend\assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Translation\backend\assets
 */
class ListAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'list.css',
    ];

    public $js = [
        'ListController.js',
        'ListController/FilterScope.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}