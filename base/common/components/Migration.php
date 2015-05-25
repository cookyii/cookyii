<?php
/**
 * Migration.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\components;

/**
 * Class Migration
 * @package common\components
 */
class Migration extends \yii\db\Migration
{

    use \common\traits\SwitchableMigrationTrait;

    /**
     * @inheritdoc
     */
    public function createTable($table, $columns, $options = null)
    {
        if ($options === null && $this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        parent::createTable($table, $columns, $options);
    }
}