<?php
/**
 * PopulateErrorsTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\traits;

/**
 * Trait PopulateErrorsTrait
 * @package cookyii\traits
 */
trait PopulateErrorsTrait
{

    /**
     * @param \yii\base\Model
     * @param string $default_attribute
     * @param array $attributes_map
     */
    public function populateErrors(\yii\base\Model $Model, $default_attribute, $attributes_map = [])
    {
        $errors = $Model->getErrors();
        foreach ($errors as $attribute => $messages) {
            $attribute = isset($attributes_map[$attribute])
                ? $attributes_map[$attribute]
                : $attribute;

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