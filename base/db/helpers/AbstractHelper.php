<?php
/**
 * AbstractHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\db\helpers;

use yii\helpers\Inflector;

/**
 * Class AbstractHelper
 * @package cookyii\db\helpers
 */
abstract class AbstractHelper extends \yii\base\Object
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