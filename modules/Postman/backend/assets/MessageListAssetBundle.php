<?php
/**
 * MessageListAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\assets;

/**
 * Class MessageListAssetBundle
 * @package cookyii\modules\Postman\backend\assets
 */
class MessageListAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

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
}