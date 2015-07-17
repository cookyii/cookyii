<?php
/**
 * EditAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Client\backend\assets;

/**
 * Class EditAssetBundle
 * @package cookyii\modules\Client\backend\assets
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
        'ClientRolesController.js',
        'ClientPropertiesController.js',
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