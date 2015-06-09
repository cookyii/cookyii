<?php
/**
 * Presenter.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\components;

use yii\helpers\Inflector;

/**
 * Class Presenter
 * @package common\components
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