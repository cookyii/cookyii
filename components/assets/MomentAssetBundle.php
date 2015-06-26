<?php
/**
 * MomentAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\assets;

/**
 * Class MomentAssetBundle
 * @package components\assets
 */
class MomentAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'moment/min/moment.min.js',
        'moment/locale/en-gb.js',
    ];
}