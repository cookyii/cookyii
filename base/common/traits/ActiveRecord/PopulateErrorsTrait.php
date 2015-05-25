<?php
/**
 * PopulateErrorsTrait.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\traits\ActiveRecord;

/**
 * Trait PopulateErrorsTrait
 * @package common\helpers
 *
 * @method hasProperty
 * @method hasAttribute
 * @method addError($attribute, $error = '')
 */
trait PopulateErrorsTrait
{

    /**
     * @param \yii\db\ActiveRecord $Model
     * @param string $default_attribute
     */
    public function populateErrors(\yii\db\ActiveRecord $Model, $default_attribute)
    {
        $errors = $Model->getErrors();
        foreach ($errors as $key => $messages) {
            $attribute = $key;
            if (false === $this->hasProperty($attribute)) {
                if (!method_exists($this, 'hasAttribute')) {
                    $attribute = $default_attribute;
                } elseif (false === $this->hasAttribute($attribute)) {
                    $attribute = $default_attribute;
                }
            }

            foreach ($messages as $mes) {
                $this->addError($attribute, $mes);
            }
        }
    }
}