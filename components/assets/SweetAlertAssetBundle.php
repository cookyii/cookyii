<?php
/**
 * SweetAlertAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\assets;

/**
 * Class SweetAlertAssetBundle
 * @package components\assets
 */
class SweetAlertAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'sweetalert/lib/sweet-alert.min.js',
    ];
}