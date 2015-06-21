<?php
/**
 * TemplateListAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Postman\backend\_assets;

/**
 * Class TemplateListAssetBundle
 * @package cookyii\modules\Postman\backend\_assets
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
    ];

    public $depends = [
        'backend\_assets\AppAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/_sources';

        parent::init();
    }
}