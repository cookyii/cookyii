<?php

use yii\db\mysql\Schema;

class m0003_user_properties extends \common\components\Migration
{

    public function up()
    {
        $this->createTable(
            '{{%user_property}}',
            [
                'user_id' => Schema::TYPE_INTEGER,
                'key' => Schema::TYPE_STRING,
                'value' => Schema::TYPE_TEXT,
                'created_at' => Schema::TYPE_INTEGER,
                'updated_at' => Schema::TYPE_INTEGER,
                'PRIMARY KEY (`user_id`, `key`)',
                'FOREIGN KEY (user_id) REFERENCES {{%user}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('{{%user_property}}');
    }
}