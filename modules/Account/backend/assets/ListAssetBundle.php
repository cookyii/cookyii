<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Account\backend\assets
 */
class ListAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'list.css',
    ];

    public $js = [
        'AccountResource.js',
        'ListController.js',
        'ListController/FilterScope.js',
        'ListController/ListScope.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}