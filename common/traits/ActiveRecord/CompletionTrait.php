<?php
/**
 * CompletionTrait.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\traits\ActiveRecord;

/**
 * Trait CompletionTrait
 * @package common\traits\ActiveRecord
 *
 * @property boolean $completed
 *
 * @method update
 */
trait CompletionTrait
{

    /**
     * @return bool
     */
    public function complete()
    {
        $this->completed = 1;

        return $this->update(false, ['completed']) === 1;
    }

    /**
     * @return bool
     */
    public function incomplete()
    {
        $this->completed = 0;

        return $this->update(false, ['completed']) === 1;
    }
}