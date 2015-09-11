<?php
/**
 * ActivatedQueryTrait.php
 * @author Revin Roman
 */

namespace cookyii\db\traits\query;

/**
 * Trait ActivatedQueryTrait
 * @package cookyii\db\traits\query
 */
trait ActivatedQueryTrait
{

    /**
     * @return static
     */
    public function onlyActivated()
    {
        $this->andWhere(['not', ['activated_at' => null]]);

        return $this;
    }

    /**
     * @return static
     */
    public function onlyDeactivated()
    {
        $this->andWhere(['activated_at' => null]);

        return $this;
    }

    /**
     * @return static
     */
    public function withoutActivated()
    {
        return $this->onlyDeactivated();
    }

    /**
     * @return static
     */
    public function withoutDeactivated()
    {
        return $this->onlyActivated();
    }
}