<?php
/**
 * TemplateListAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\assets;

/**
 * Class TemplateListAssetBundle
 * @package cookyii\modules\Postman\backend\assets
 */
class TemplateListAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'template-list.css',
    ];

    public $js = [
        'TemplateResource.js',
        'template/ListController.js',
        'template/ListController/FilterScope.js',
        'template/ListController/ListScope.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}