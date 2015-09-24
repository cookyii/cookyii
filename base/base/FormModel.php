<?php
/**
 * FormModel.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\base;

/**
 * Class FormModel
 * @package cookyii\base
 */
abstract class FormModel extends \yii\base\Model
{

    /**
     * @return array
     */
    abstract public function formAction();

    /**
     * @return string
     */
    public function getClass()
    {
        $class = explode('\\', get_called_class());

        return array_pop($class);
    }
}