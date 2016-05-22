<?php
/**
 * TemplateEditAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\assets;

/**
 * Class TemplateEditAssetBundle
 * @package cookyii\modules\Postman\backend\assets
 */
class TemplateEditAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $css = [
        'template-edit.css',
    ];

    public $js = [
        'TemplateResource.js',
        'template/DetailController.js',
        'template/EditController.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}