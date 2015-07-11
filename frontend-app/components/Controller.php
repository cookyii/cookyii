<?php
/**
 * Controller.php
 * @author Revin Roman
 * @link https://rmrevin.ru
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

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => $this->accessRules(),
            ],
        ];
    }

    /**
     * @return array
     */
    abstract protected function accessRules();
}