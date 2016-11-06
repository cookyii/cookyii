<?php
/**
 * AdminLteAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\assets;

/**
 * Class AdminLteAssetBundle
 * @package cookyii\assets
 */
class AdminLteAssetBundle extends AbstractModuleAssetBundle
{

    public $path = __DIR__;

    public $js = [
        'js/adminlte.js',
    ];

    public $css = [
        'css/adminlte.css',
    ];
}
