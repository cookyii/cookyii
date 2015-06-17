<?php
/**
 * EditAssetBundle.php
 * @author Revin Roman
 */

namespace backend\modules\Account\views\_assets;

/**
 * Class EditAssetBundle
 * @package backend\modules\Account\views\_assets
 */
class EditAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/modules/Account/views/_assets/_sources';

    public $css = [
        'edit.css',
    ];

    public $js = [
        'UserResource.js',
        'AccountDetailController.js',
        'AccountEditController.js',
        'AccountRolesController.js',
        'AccountPropertiesController.js',
    ];

    public $depends = [
        'backend\_assets\AppAsset',
    ];
}