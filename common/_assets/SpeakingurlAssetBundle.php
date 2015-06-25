<?php
/**
 * SpeakingurlAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\_assets;

/**
 * Class SpeakingurlAssetBundle
 * @package common\_assets
 */
class SpeakingUrlAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'speakingurl/speakingurl.min.js',
    ];
}