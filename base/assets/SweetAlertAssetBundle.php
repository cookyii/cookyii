<?php
/**
 * SweetAlertAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets;

/**
 * Class SweetAlertAssetBundle
 * @package cookyii\assets
 */
class SweetAlertAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'sweetalert/dist/sweetalert.min.js',
    ];
}
