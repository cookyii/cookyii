<?php
/**
 * FormAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\_assets\jquery\cdn;

/**
 * Class FormAssetBundle
 * @package common\_assets\jquery\cdn
 */
class FormAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}