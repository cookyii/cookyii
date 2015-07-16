<?php
/**
 * MessageListAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Postman\backend\assets;

/**
 * Class MessageListAssetBundle
 * @package cookyii\modules\Postman\backend\assets
 */
class MessageListAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'message-list.css',
    ];

    public $js = [
        'MessageResource.js',
        'MessageListController.js',
        'MessageListController/FilterScope.js',
        'MessageListController/MessageListScope.js',
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