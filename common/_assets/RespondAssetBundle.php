<?php
/**
 * RespondAssetBundle.php
 * @author Revin Roman
 */

namespace common\_assets;

/**
 * Class RespondAssetBundle
 * @package common\_assets
 */
class RespondAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js',
    ];

    public $jsOptions = [
        'condition' => 'lt IE 9',
    ];
}