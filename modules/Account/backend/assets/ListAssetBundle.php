<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
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
        'AccountListController/FilterScope.js',
        'AccountListController/AccountListScope.js',
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