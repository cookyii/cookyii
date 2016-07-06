<?php
/**
 * Migration.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\db;

use yii\helpers\Json;

/**
 * Class Migration
 * @package cookyii\db
 */
class Migration extends \yii\db\Migration
{

    use \cookyii\db\traits\MigrationCheckSupportTrait;

    public $default = [
        'charset' => 'utf8',
        'collate' => 'utf8_unicode_ci',
        'engine' => 'InnoDB',
    ];

    /**
     * @inheritdoc
     */
    public function createTable($table, $columns, $options = null)
    {
        if ($options === null && $this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $options = sprintf(
                'CHARACTER SET %s COLLATE %s ENGINE=%s',
                $this->default['charset'],
                $this->default['collate'],
                $this->default['engine']
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
     * @param int $defaultValue
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function boolean($defaultValue = 0)
    {
        return $this->boolean()->notNull()->defaultValue($defaultValue);
    }

    /**
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function unixTimestamp()
    {
        return $this->integer(10)->unsigned();
    }

    /**
     * @param string $code
     * @param string $subject
     * @param string $description
     * @param array $content
     * @param array $params
     * @param array $options
     */
    public function insertPostmanMessageTemplate($code, $subject, $description, array $content, array $params = [], array $options = [])
    {
        $time = time();

        $options = array_merge([
            'code' => $code,
            'subject' => $subject,
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => null,
            'description' => $description,
            'address' => Json::encode([]),
            'params' => Json::encode($params),
            'use_layout' => true,
            'created_at' => $time,
            'updated_at' => $time,
            'deleted_at' => null,
        ], $options);

        $this->insert('{{%postman_template}}', $options);
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
