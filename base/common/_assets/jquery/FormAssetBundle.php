<?php
/**
 * FormAssetBundle.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\_assets\jquery;

/**
 * Class FormAssetBundle
 * @package common\_assets\jquery
 */
class FormAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.js',
    ];

    public $depends = [
        \yii\web\JqueryAsset::class,
    ];
}