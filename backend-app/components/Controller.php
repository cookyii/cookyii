<?php
/**
 * Controller.php
 * @author Revin Roman
 */

namespace backend\components;

/**
 * Class Controller
 * @package backend\components
 */
class Controller extends \yii\web\Controller
{

    public $loader = true;

    public $layout = '//main';

    public $public = false;

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

        if (!$this->public && User()->isGuest) {
            User()->loginRequired();
        }
    }
}