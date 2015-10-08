<?php
/**
 * SignInAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend\assets;

/**
 * Class SignInAssetBundle
 * @package cookyii\modules\Account\frontend\assets
 */
class SignInAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath;

    public $css = [
        'styles.css',
    ];

    public $js = [
        'SignInController.js',
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