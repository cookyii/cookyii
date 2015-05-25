<?php
/**
 * SwitchableMigrationTrait.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\traits;

/**
 * Trait SwitchableMigrationTrait
 * @package common\traits
 *
 * @property $db
 */
trait SwitchableMigrationTrait
{

    protected $db_type = 'master';

    public function init()
    {
        AuthManager()->db = DB();
    }

    protected function switchTestDb()
    {
        $this->db_type = $this->db_type === 'master' ? 'test' : 'master';
        $this->db = \yii\di\Instance::ensure($this->db_type === 'master' ? 'db' : 'db.test', \yii\db\Connection::class);

        echo "  > switch database to `{$this->db_type}` ...\n";
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        echo "  > database `{$this->db_type}` ...\n";

        $result = parent::up();
        if (!$this->isProduction()) {
            $this->switchTestDb();
            $result = parent::up();
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        echo "  > database `{$this->db_type}` ...\n";

        $result = parent::down();
        if (!$this->isProduction()) {
            $this->switchTestDb();
            $result = parent::down();
        }

        return $result;
    }

    /**
     * @return bool
     */
    private function isProduction()
    {
        return in_array(YII_ENV, ['prod', 'production']);
    }
}