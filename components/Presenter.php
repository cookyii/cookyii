<?php
/**
 * Presenter.php
 * @author Revin Roman
 */

namespace components;

use yii\helpers\Inflector;

/**
 * Class Presenter
 * @package components
 */
abstract class Presenter extends \yii\base\Object
{

    /** @var \yii\db\ActiveRecord */
    public $Model;

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        return parent::__get(Inflector::camelize($name));
    }
}