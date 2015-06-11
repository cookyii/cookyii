<?php
/**
 * SignInAssetBundle.php
 * @author Revin Roman
 */

namespace backend\modules\Account\views\_assets;

/**
 * Class SignInAssetBundle
 * @package backend\modules\Account\views\_assets
 */
class SignInAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/modules/Account/views/_assets/_sources';

    public $css = [
        'signin.css',
    ];

    public $js = [
        'SignInController.js',
    ];

    public $depends = [
        'backend\_assets\AppAsset',
    ];
}