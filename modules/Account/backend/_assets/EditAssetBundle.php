<?php
/**
 * EditAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\backend\_assets;

/**
 * Class EditAssetBundle
 * @package cookyii\modules\Account\backend\_assets
 */
class EditAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'AccountResource.js',
        'AccountDetailController.js',
        'AccountEditController.js',
        'AccountRolesController.js',
        'AccountPropertiesController.js',
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