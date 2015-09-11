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
class TemplateListAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'template-list.css',
    ];

    public $js = [
        'TemplateResource.js',
        'TemplateListController.js',
        'TemplateListController/FilterScope.js',
        'TemplateListController/TemplateListScope.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/_sources';

        parent::init();
    }
}