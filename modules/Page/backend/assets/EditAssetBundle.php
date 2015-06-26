<?php
/**
 * EditAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Page\backend\assets;

/**
 * Class EditAssetBundle
 * @package cookyii\modules\Page\backend\assets
 */
class EditAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'PageResource.js',
        'PageDetailController.js',
        'PageEditController.js',
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