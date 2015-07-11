<?php
/**
 * CompletionTrait.php
 * @author Revin Roman
 */

namespace components\db\traits;

/**
 * Trait CompletionTrait
 * @package components\db\traits
 *
 * @property boolean $completed_at
 */
trait CompletionTrait
{

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return !empty($this->completed_at);
    }

    /**
     * @return bool
     */
    public function isNotCompleted()
    {
        return !$this->isCompleted();
    }

    /**
     * @return integer|boolean the number of rows affected, or false if validation fails
     * or [[beforeSave()]] stops the updating process.
     * @throws \yii\base\InvalidConfigException
     */
    public function complete()
    {
        if (!$this->hasAttribute('completed_at') && !$this->hasProperty('completed_at')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'completed_at'));
        }
        
        $this->completed_at = time();

        return $this->update();
    }

    /**
     * @return integer|boolean the number of rows affected, or false if validation fails
     * or [[beforeSave()]] stops the updating process.
     * @throws \yii\base\InvalidConfigException
     */
    public function incomplete()
    {
        if (!$this->hasAttribute('completed_at') && !$this->hasProperty('completed_at')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'completed_at'));
        }
        
        $this->completed_at = null;

        return $this->update();
    }
}