<?php
/**
 * DateTimePickerAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets\jquery;

/**
 * Class DateTimePickerAssetBundle
 * @package cookyii\assets\jquery
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

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $langFile = sprintf('bootstrap-datetimepicker.%s.js', \Yii::$app->language);

        if (file_exists(\Yii::getAlias('@bower/smalot-bootstrap-datetimepicker/js/locales/') . $langFile)) {
            $this->js[] = 'smalot-bootstrap-datetimepicker/js/locales/' . $langFile;
        }
    }
}
