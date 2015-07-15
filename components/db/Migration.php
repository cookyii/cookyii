<?php
/**
 * Migration.php
 * @author Revin Roman
 */

namespace cookyii\db;

/**
 * Class Migration
 * @package cookyii\db
 */
class Migration extends \yii\db\Migration
{

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