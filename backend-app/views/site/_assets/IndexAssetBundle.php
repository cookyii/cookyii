<?php
/**
 * IndexAssetBundle.php
 * @author Revin Roman
 */

namespace backend\views\site\_assets;


class IndexAssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = '@backend/views/site/_assets/_sources';

    public $css = [
        'index.css',
    ];

    public $js = [
        'IndexController.js',
    ];

    public $depends = [
        'backend\_assets\AppAsset',
    ];
}