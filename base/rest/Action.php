<?php
/**
 * Action.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\rest;

/**
 * Class Action
 * @package cookyii\rest
 */
class Action extends \yii\rest\Action
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        /** @var \yii\base\Object $ModelClass */
        $ModelClass = \Yii::createObject($this->modelClass);

        $this->modelClass = $ModelClass::className();

        unset($ModelClass);
    }
}
