<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\backend\assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Account\backend\assets
 */
class ListAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'list.css',
    ];

    public $js = [
        'AccountResource.js',
        'AccountListController.js',
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