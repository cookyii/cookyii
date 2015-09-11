<?php
/**
 * EditAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\assets;

/**
 * Class EditAssetBundle
 * @package cookyii\modules\Client\crm\assets
 */
class EditAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'ClientResource.js',
        'ClientDetailController.js',
        'ClientEditController.js',
        'ClientPropertiesController.js',
    ];

    public $depends = [
        'crm\assets\AppAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/_sources';

        parent::init();
    }
}