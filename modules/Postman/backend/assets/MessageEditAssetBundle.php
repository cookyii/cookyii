<?php
/**
 * MessageEditAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\assets;

/**
 * Class MessageEditAssetBundle
 * @package cookyii\modules\Postman\backend\assets
 */
class MessageEditAssetBundle extends \cookyii\assets\AbstractModuleAssetBundle
{

    public $path = __DIR__;

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
}