<?php
/**
 * ActivationTrait.php
 * @author Revin Roman
 */

namespace components\db\traits;

/**
 * Trait ActivationTrait
 * @package components\db\traits
 *
 * @property bool $activated
 *
 * @method hasAttribute
 * @method hasProperty
 * @method update
 */
trait ActivationTrait
{

    /**
     * @return bool
     */
    public function isActivated()
    {
        return $this->activated === 1;
    }

    /**
     * @return bool
     */
    public function isNotActivated()
    {
        return $this->activated === 0;
    }

    /**
     * integer|boolean the number of rows affected, or false if validation fails
     * or [[beforeSave()]] stops the updating process.
     * @throws \yii\base\InvalidConfigException
     */
    public function activate()
    {
        if (!$this->hasAttribute('activated') && !$this->hasProperty('activated')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'activated'));
        }

        $this->activated = 1;

        return $this->update();
    }

    /**
     * integer|boolean the number of rows affected, or false if validation fails
     * or [[beforeSave()]] stops the updating process.
     * @throws \yii\base\InvalidConfigException
     */
    public function deactivate()
    {
        if (!$this->hasAttribute('activated') && !$this->hasProperty('activated')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'activated'));
        }

        $this->activated = 0;

        return $this->update();
    }
}