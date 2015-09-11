<?php
/**
 * ForgotPasswordAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\assets;

/**
 * Class ForgotPasswordAssetBundle
 * @package cookyii\modules\Account\frontend\assets
 */
class ForgotPasswordAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'forgot-password.css',
    ];

    public $js = [
        'ForgotPasswordController.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/_sources';

        parent::init();
    }
}