<?php
/**
 * SpeakingurlAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets;

/**
 * Class SpeakingurlAssetBundle
 * @package cookyii\assets
 */
class SpeakingUrlAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'speakingurl/speakingurl.min.js',
    ];
}