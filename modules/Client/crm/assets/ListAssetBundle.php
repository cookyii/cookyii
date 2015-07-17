<?php
/**
 * ListAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Client\crm\assets;

/**
 * Class ListAssetBundle
 * @package cookyii\modules\Client\crm\assets
 */
class ListAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'list.css',
    ];

    public $js = [
        'ClientResource.js',
        'ClientListController.js',
        'ClientListController/FilterScope.js',
        'ClientListController/ClientListScope.js',
    ];

    public $depends = [
        'crm\assets\AppAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/_sources';

        parent::init();
    }
}