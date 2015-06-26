<?php
/**
 * SpeakingurlAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\assets;

/**
 * Class SpeakingurlAssetBundle
 * @package components\assets
 */
class SpeakingUrlAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'speakingurl/speakingurl.min.js',
    ];
}