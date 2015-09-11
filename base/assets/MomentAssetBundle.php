<?php
/**
 * MomentAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets;

/**
 * Class MomentAssetBundle
 * @package cookyii\assets
 */
class MomentAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'moment/min/moment.min.js',
        'moment/locale/en-gb.js',
    ];
}