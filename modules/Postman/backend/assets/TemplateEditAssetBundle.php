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
class TemplateEditAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'template-edit.css',
    ];

    public $js = [
        'TemplateResource.js',
        'TemplateDetailController.js',
        'TemplateEditController.js',
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