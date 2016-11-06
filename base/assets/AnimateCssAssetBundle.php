<?php
/**
 * AnimateCssAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets;

/**
 * Class AnimateCssAssetBundle
 * @package cookyii\assets
 */
class AnimateCssAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $css = [
        'animate.css/animate.min.css',
    ];
}
