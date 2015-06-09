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

    public $hideLoader = false;

    public $public = false;

    public $layout = 'main';

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