<?php
/**
 * Controller.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\web;

use cookyii\Facade as F;
use yii\filters\AccessControl;

/**
 * Class Controller
 * @package cookyii\web
 */
abstract class Controller extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (isset($_GET['clear'])) {
            F::Cache()->flush();
            F::Cache('authManager')->flush();
            F::Cache('schema')->flush();
            F::Cache('query')->flush();

            if (function_exists('opcache_reset')) {
                opcache_reset();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => $this->accessRules(),
            ],
        ];
    }

    /**
     * @return array
     */
    abstract protected function accessRules();
}
