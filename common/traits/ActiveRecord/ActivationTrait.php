<?php
/**
 * ActivationTrait.php
 * @author Revin Roman
 */

namespace common\traits\ActiveRecord;

/**
 * Trait ActivationTrait
 * @package common\traits\ActiveRecord
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
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function activate()
    {
        if (!$this->hasAttribute('activated') && !$this->hasProperty('activated')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'activated'));
        }

        $this->activated = 1;

        return $this->update(false, ['activated']) === 1;
    }

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function deactivate()
    {
        if (!$this->hasAttribute('activated') && !$this->hasProperty('activated')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'activated'));
        }

        $this->activated = 0;

        return $this->update(false, ['activated']) === 1;
    }
}