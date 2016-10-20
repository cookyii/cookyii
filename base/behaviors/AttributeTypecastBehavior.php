<?php
/**
 * AttributeTypecastBehavior.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\behaviors;

/**
 * Class AttributeTypecastBehavior
 * @package cookyii\behaviors
 */
class AttributeTypecastBehavior extends \yii\behaviors\AttributeTypecastBehavior
{

    private static $autoDetectedAttributeTypes = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
    }

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if ($this->attributeTypes === null) {
            $this->reinitAutoDetectedAttributeTypes();
        }
    }

    /**
     * Reinitialization typecast attributes for model
     */
    public function reinitAutoDetectedAttributeTypes()
    {
        $ownerClass = get_class($this->owner);
        if (!isset(self::$autoDetectedAttributeTypes[$ownerClass])) {
            self::$autoDetectedAttributeTypes[$ownerClass] = $this->detectAttributeTypes();
        }
        $this->attributeTypes = self::$autoDetectedAttributeTypes[$ownerClass];
    }
}
