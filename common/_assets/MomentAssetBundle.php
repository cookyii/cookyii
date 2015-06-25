<?php
/**
 * MomentAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\_assets;

/**
 * Class MomentAssetBundle
 * @package common\_assets
 */
class MomentAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'moment/min/moment.min.js',
        'moment/locale/en-gb.js',
    ];
}