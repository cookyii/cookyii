<?php
/**
 * Controller.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\web;

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
            Cache()->flush();
            Cache('authManager')->flush();
            Cache('schema')->flush();
            Cache('query')->flush();
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => $this->accessRules(),
            ],
        ];
    }

    /**
     * @return array
     */
    abstract protected function accessRules();
}