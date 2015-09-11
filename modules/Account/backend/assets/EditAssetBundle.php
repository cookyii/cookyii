<?php
/**
 * EditAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\assets;

/**
 * Class EditAssetBundle
 * @package cookyii\modules\Account\backend\assets
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
        'backend\assets\AppAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/_sources';

        parent::init();
    }
}