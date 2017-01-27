<?php
/**
 * GetHelperTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\db\traits;

/**
 * Trait GetHelperTrait
 * @package cookyii\db\traits
 */
trait GetHelperTrait
{

    /**
     * @var \cookyii\db\helpers\AbstractHelper[]
     */
    private $_helpers = [];

    /**
     * @param string $helperClass
     * @return \cookyii\db\helpers\AbstractHelper
     * @throws \yii\base\InvalidConfigException
     */
    protected function getHelper($helperClass)
    {
        if (empty($helperClass)) {
            throw new \yii\base\InvalidConfigException('The "$helperClass" property must be set.');
        }

        if (!class_exists($helperClass)) {
            throw new \yii\base\InvalidConfigException(sprintf('Class "%s" not found.', $helperClass));
        }

        if (!isset($this->_helpers[$helperClass])) {
            $this->_helpers[$helperClass] = \Yii::createObject([
                'class' => $helperClass,
                'Model' => $this,
            ]);
        }

        return $this->_helpers[$helperClass];
    }
}
