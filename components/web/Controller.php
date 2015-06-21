<?php
/**
 * Controller.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\web;

/**
 * Class Controller
 * @package components\web
 */
class Controller extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (isset($_GET['clear'])) {
            Cache()->flush();
            Cache('authManager')->flush();
            Cache('schema')->flush();
            Cache('query')->flush();
        }
    }
}