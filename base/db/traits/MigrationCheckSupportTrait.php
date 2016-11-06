<?php
/**
 * MigrationCheckSupportTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\db\traits;

/**
 * Trait MigrationCheckSupportTrait
 * @package cookyii\db\traits
 */
trait MigrationCheckSupportTrait
{

    /**
     * @inheritdoc
     */
    public function alterColumn($table, $column, $type)
    {
        try {
            parent::alterColumn($table, $column, $type);
        } catch (\yii\base\NotSupportedException $Exception) {
            echo ' Alter column not supported.' . "\n";
        } catch (\Exception $Exception) {
            echo ' Raise error: ' . $Exception->getMessage() . "\n";
        }
    }

    /**
     * @inheritdoc
     */
    public function renameColumn($table, $oldName, $newName)
    {
        try {
            parent::renameColumn($table, $oldName, $newName);
        } catch (\yii\base\NotSupportedException $Exception) {
            echo ' Rename column not supported.' . "\n";
        } catch (\Exception $Exception) {
            echo ' Raise error: ' . $Exception->getMessage() . "\n";
        }
    }

    /**
     * @inheritdoc
     */
    public function dropColumn($table, $column)
    {
        try {
            parent::dropColumn($table, $column);
        } catch (\yii\base\NotSupportedException $Exception) {
            echo ' Drop column not supported.' . "\n";
        } catch (\Exception $Exception) {
            echo ' Raise error: ' . $Exception->getMessage() . "\n";
        }
    }

    /**
     * @inheritdoc
     */
    public function addPrimaryKey($name, $table, $columns)
    {
        try {
            parent::addPrimaryKey($name, $table, $columns);
        } catch (\yii\base\NotSupportedException $Exception) {
            echo ' Primary key not supported.' . "\n";
        } catch (\Exception $Exception) {
            echo ' Raise error: ' . $Exception->getMessage() . "\n";
        }
    }

    /**
     * @inheritdoc
     */
    public function dropPrimaryKey($name, $table)
    {
        try {
            parent::dropPrimaryKey($name, $table);
        } catch (\yii\base\NotSupportedException $Exception) {
            echo ' Primary key not supported.' . "\n";
        } catch (\Exception $Exception) {
            echo ' Raise error: ' . $Exception->getMessage() . "\n";
        }
    }

    /**
     * @inheritdoc
     */
    public function addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete = null, $update = null)
    {
        try {
            parent::addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete, $update);
        } catch (\yii\base\NotSupportedException $Exception) {
            echo ' Foreign key not supported.' . "\n";
        } catch (\Exception $Exception) {
            echo ' Raise error: ' . $Exception->getMessage() . "\n";
        }
    }

    /**
     * @inheritdoc
     */
    public function dropForeignKey($name, $table)
    {
        try {
            parent::dropForeignKey($name, $table);
        } catch (\yii\base\NotSupportedException $Exception) {
            echo ' Foreign key not supported.' . "\n";
        } catch (\Exception $Exception) {
            echo ' Raise error: ' . $Exception->getMessage() . "\n";
        }
    }
}
