<?php
/**
 * EditSectionAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\_assets;

/**
 * Class EditSectionAssetBundle
 * @package cookyii\modules\Feed\backend\_assets
 */
class EditSectionAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'SectionResource.js',
        'SectionDetailController.js',
        'SectionEditController.js',
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