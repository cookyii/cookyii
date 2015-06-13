<?php
/**
 * DetailAssetBundle.php
 * @author Revin Roman
 */

namespace backend\modules\Account\views\_assets;

/**
 * Class DetailAssetBundle
 * @package backend\modules\Account\views\_assets
 */
class DetailAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/modules/Account/views/_assets/_sources';

    public $css = [
        'detail.css',
    ];

    public $js = [
        'UserResource.js',
        'AccountDetailController.js',
    ];

    public $depends = [
        'backend\_assets\AppAsset',
    ];
}