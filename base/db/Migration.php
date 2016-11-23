<?php
/**
 * Migration.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\db;

use cookyii\console\controllers\MigrateController;

/**
 * Class Migration
 * @package cookyii\db
 */
class Migration extends \yii\db\Migration
{

    use \cookyii\db\traits\MigrationCheckSupportTrait;

    /**
     * @var array
     */
    public $config = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $controller = \Yii::$app->controller;

        $this->config = $controller instanceof MigrateController
            ? $controller->migrationConfig
            : [];
    }

    /**
     * @inheritdoc
     */
    public function createTable($table, $columns, $options = null)
    {
        if ($options === null && $this->db->driverName === 'mysql') {
            $options = sprintf(
                'CHARACTER SET %s COLLATE %s ENGINE=%s ROW_FORMAT=%s',
                $this->config['charset'],
                $this->config['collate'],
                $this->config['engine'],
                $this->config['row-format']
            );
        }

        if (isset($columns['schema']) && is_array($columns['schema'])) {
            parent::createTable($table, $columns['schema'], $options);

            if (isset($columns['pkey'])) {
                $this->addPrimaryKey('pkey', $table, $columns['pkey']);
            }

            if (isset($columns['pkeys'])) {
                foreach ($columns['pkeys'] as $name => $cols) {
                    $this->addPrimaryKey($name, $table, $cols);
                }
            }

            if (isset($columns['indexes'])) {
                foreach ($columns['indexes'] as $name => $cols) {
                    $this->createIndex($name, $table, $cols);
                }
            }

            if (isset($columns['uniques'])) {
                foreach ($columns['uniques'] as $name => $cols) {
                    $this->createIndex($name, $table, $cols, true);
                }
            }

            if (isset($columns['fkeys'])) {
                foreach ($columns['fkeys'] as $name => $config) {
                    $this->addForeignKey(
                        $name,
                        $table, $config['from'],
                        $config['to'][0], $config['to'][1],
                        isset($config['delete']) ? $config['delete'] : null,
                        isset($config['update']) ? $config['update'] : null
                    );
                }
            }
        } else {
            parent::createTable($table, $columns, $options);
        }
    }

    /**
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function boolean()
    {
        return parent::boolean()->notNull();
    }

    /**
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function unixTimestamp()
    {
        return $this->integer(10)->unsigned();
    }

    /**
     * @param integer $count
     * @param integer|array $maxNbChars
     * @return string
     */
    protected function getFakerTextBlock($count = 1, $maxNbChars = 200)
    {
        $result = '';

        $faker = \Faker\Factory::create();

        $maxNbChars = is_array($maxNbChars)
            ? rand($maxNbChars[0], $maxNbChars[1])
            : $maxNbChars;

        for ($i = 0; $i < $count; $i++) {
            $result .= sprintf('<p>%s</p>', $faker->realText($maxNbChars));
        }

        return $result;
    }
}
