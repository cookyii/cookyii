<?php
/**
 * Controller.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace frontend\components;

/**
 * Class Controller
 * @package frontend\components
 */
abstract class Controller extends \cookyii\web\Controller
{

    public $hideLoader = false;

    public $layout = '//main';
}