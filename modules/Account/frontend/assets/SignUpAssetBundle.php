<?php
/**
 * SignUpAssetBundle.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\frontend\assets;

/**
 * Class SignUpAssetBundle
 * @package cookyii\modules\Account\frontend\assets
 */
class SignUpAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'signup.css',
    ];

    public $js = [
        'SignUpController.js',
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