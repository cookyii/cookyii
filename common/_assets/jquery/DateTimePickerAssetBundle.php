<?php
/**
 * DateTimePickerAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\_assets\jquery;

/**
 * Class DateTimePickerAssetBundle
 * @package common\_assets\jquery
 */
class DateTimePickerAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@bower';

    public $js = [
        'smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}