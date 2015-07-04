<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Feed\backend\assets
 */
class ListAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'list.css',
    ];

    public $js = [
        'SectionResource.js',
        'ItemResource.js',
        'ListController.js',
        'ListController/FilterScope.js',
        'ListController/ItemScope.js',
        'ListController/SectionScope.js',
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