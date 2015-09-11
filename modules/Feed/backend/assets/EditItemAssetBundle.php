<?php
/**
 * EditItemAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Feed\backend\assets;

/**
 * Class EditItemAssetBundle
 * @package cookyii\modules\Feed\backend\assets
 */
class EditItemAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'edit.css',
    ];

    public $js = [
        'SectionDropdownScope.js',
        'SectionResource.js',
        'ItemResource.js',
        'ItemDetailController.js',
        'ItemEditController.js',
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