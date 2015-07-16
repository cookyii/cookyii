<?php
/**
 * MessageEditAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Postman\backend\assets;

/**
 * Class MessageEditAssetBundle
 * @package cookyii\modules\Postman\backend\assets
 */
class MessageEditAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'message-edit.css',
    ];

    public $js = [
        'MessageResource.js',
        'MessageDetailController.js',
        'MessageEditController.js',
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