<?php
/**
 * CompletedQueryTrait.php
 * @author Revin Roman
 */

namespace components\db\traits\query;

/**
 * Trait CompletedQueryTrait
 * @package components\db\traits\query
 */
trait CompletedQueryTrait
{

    /**
     * @return static
     */
    public function onlyCompleted()
    {
        $this->andWhere(['not', ['completed_at' => null]]);

        return $this;
    }

    /**
     * @return static
     */
    public function onlyNotCompleted()
    {
        $this->andWhere(['completed_at' => null]);

        return $this;
    }

    /**
     * @return static
     */
    public function withoutCompleted()
    {
        return $this->onlyNotCompleted();
    }

    /**
     * @return static
     */
    public function withoutNotCompleted()
    {
        return $this->onlyCompleted();
    }
}