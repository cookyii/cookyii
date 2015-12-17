<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Client\crm\assets
 */
class ListAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'list.css',
    ];

    public $js = [
        'ClientResource.js',
        'ClientListController.js',
        'ClientListController/FilterScope.js',
        'ClientListController/ClientListScope.js',
    ];

    public $depends = [
        'crm\assets\AppAsset',
    ];
}