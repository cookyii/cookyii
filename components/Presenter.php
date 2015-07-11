<?php
/**
 * Presenter.php
 * @author Revin Roman
 */

namespace cookyii;

use yii\helpers\Inflector;

/**
 * Class Presenter
 * @package cookyii
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