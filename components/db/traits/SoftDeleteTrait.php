<?php
/**
 * SoftDeleteTrait.php
 * @author Revin Roman
 */

namespace components\db\traits;

/**
 * Trait SoftDeleteTrait
 * @package components\db\traits
 *
 * Трейт переопределяет метод delete в ActiveRecord классе.
 * Теперь, при первом вызове метода delete, запись не будет физически удалена из базы данных,
 * а только лишь помечается удалённой (deleted=1)
 *
 * При повторном вызове метода delete, запись будет удалена полностью из базы
 *
 * @property bool $activated_at
 * @property bool $deleted_at
 */
trait SoftDeleteTrait
{

    public $deleted;

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return !empty($this->deleted_at);
    }

    /**
     * @return bool
     */
    public function isNotDeleted()
    {
        return !$this->isDeleted();
    }

    /**
     * @param bool $permanently если true, то запись будет безусловно удалена, восстановить (@see restore) её будет нельзя
     * @return integer|boolean the number of rows affected, or false if validation fails
     * or [[beforeSave()]] stops the updating process.
     * @throws \yii\base\InvalidConfigException
     */
    public function delete($permanently = false)
    {
        if (!$this->hasAttribute('deleted_at') && !$this->hasProperty('deleted_at')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'deleted_at'));
        }

        if (true === $permanently || $this->isDeleted()) {
            // permanently delete
            $result = parent::delete();
        } else {
            // soft delete
            $this->deleted_at = time();

            $result = $this->update();
        }

        return $result;
    }

    /**
     * @return integer|boolean the number of rows affected, or false if validation fails
     * or [[beforeSave()]] stops the updating process.
     * @throws \yii\base\InvalidConfigException
     */
    public function restore()
    {
        if (!$this->hasAttribute('deleted_at') && !$this->hasProperty('deleted_at')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'deleted_at'));
        }

        $this->deleted_at = null;

        return $this->update();
    }
}