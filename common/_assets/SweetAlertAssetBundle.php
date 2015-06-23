<?php
/**
 * SweetAlertAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\_assets;

/**
 * Class SweetAlertAssetBundle
 * @package common\_assets
 */
class SweetAlertAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'sweetalert/lib/sweet-alert.min.js',
    ];
}