<?php
/**
 * CodeMirrorAssetBundle.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\_assets;

/**
 * Class CodeMirrorAssetBundle
 * @package common\_assets
 */
class CodeMirrorAssetBundle extends \yii\web\AssetBundle
{

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/addon/selection/selection-pointer.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/addon/mode/multiplex.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/addon/display/fullscreen.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/addon/display/panel.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/htmlmixed/htmlmixed.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/javascript/javascript.js',
        'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/css/css.js',
    ];
}