<?php
/**
 * SignInAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\crm\assets;

/**
 * Class SignInAssetBundle
 * @package cookyii\modules\Account\crm\assets
 */
class SignInAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'signin.css',
    ];

    public $js = [
        'SignInController.js',
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