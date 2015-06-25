<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\_assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Feed\backend\_assets
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