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
        'message/ListController.js',
        'message/ListController/FilterScope.js',
        'message/ListController/ListScope.js',
    ];

    public $depends = [
        'backend\assets\AppAsset',
    ];
}