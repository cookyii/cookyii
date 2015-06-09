<?php
/**
 * SoftDeleteTrait.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\traits\ActiveRecord;

/**
 * Trait SoftDeleteTrait
 * @package common\traits\ActiveRecord
 *
 * Трейт переопределяет метод delete в ActiveRecord классе.
 * Теперь, при первом вызове метода delete, запись не будет физически удалена из базы данных,
 * а только лишь помечается удалённой (deleted=1)
 *
 * При повторном вызове метода delete, запись будет удалена полностью из базы
 *
 * @property bool $deleted
 *
 * @method hasAttribute
 * @method hasProperty
 * @method update
 */
trait SoftDeleteTrait
{

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted === 1;
    }

    /**
     * @return bool
     */
    public function isNotDeleted()
    {
        return $this->deleted === 0;
    }

    /**
     * @param bool $permanently если true, то запись будет безусловно удалена, восстановить (@see restore) её будет нельзя
     * @return integer|false количество удаленных строк, или false если призошла ошибка.
     * Помните, может быть удалено 0 (ноль) строк, и это считается успешным завершением метода.
     * @throws \yii\base\InvalidConfigException
     */
    public function delete($permanently = false)
    {
        if (!$this->hasAttribute('deleted') && !$this->hasProperty('deleted')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'deleted'));
        }

        if (true === $permanently || $this->isDeleted()) {
            // permanently delete
            $result = parent::delete();
        } else {
            // soft delete
            $this->deleted = 1;
            $result = $this->update(false, ['deleted']);
        }

        return $result;
    }

    /**
     * @return integer|false количество удаленных строк, или false если призошла ошибка.
     * Помните, может быть удалено 0 (ноль) строк, и это считается успешным завершением метода.
     * @throws \yii\base\InvalidConfigException
     */
    public function restore()
    {
        if (!$this->hasAttribute('deleted') && !$this->hasProperty('deleted')) {
            throw new \yii\base\InvalidConfigException(sprintf('`%s` has no attribute named `%s`.', get_class($this), 'deleted'));
        }

        $this->deleted = 0;

        return $this->update(false, ['deleted']);
    }
}