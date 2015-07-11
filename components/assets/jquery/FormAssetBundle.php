<?php
/**
 * FormAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\assets\jquery;

/**
 * Class FormAssetBundle
 * @package cookyii\assets\jquery
 */
class FormAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'jquery-form/jquery.form.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}