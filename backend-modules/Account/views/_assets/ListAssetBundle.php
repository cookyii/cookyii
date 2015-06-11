<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\modules\Account\views\_assets;

/**
 * Class ListAssetBundle
 * @package backend\modules\Account\views\_assets
 */
class ListAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/modules/Account/views/_assets/_sources';

    public $css = [
        'list.css',
    ];

    public $js = [
        'UserResource.js',
        'UserListController.js',
        'UserEditController.js',
    ];

    public $depends = [
        'backend\_assets\AppAsset',
    ];
}