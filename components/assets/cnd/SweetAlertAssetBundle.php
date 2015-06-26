<?php
/**
 * SweetAlertAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\assets\cdn;

/**
 * Class SweetAlertAssetBundle
 * @package components\assets\cdn
 */
class SweetAlertAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.5.0/sweet-alert.min.js',
    ];
}