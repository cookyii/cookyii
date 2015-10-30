<?php
/**
 * ListAssetBundle.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Translation\backend\assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Translation\backend\assets
 */
class ListAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'list.css',
    ];

    public $js = [
        'TranslationListController/FilterScope.js',
        'TranslationListController.js',
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