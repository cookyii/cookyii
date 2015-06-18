<?php

use yii\db\mysql\Schema;

class m150610_170115_account_properties extends \common\components\Migration
{

    public function up()
    {
        $this->createTable(
            '{{%account_property}}',
            [
                'account_id' => Schema::TYPE_INTEGER,
                'key' => Schema::TYPE_STRING,
                'value' => Schema::TYPE_TEXT,
                'created_at' => Schema::TYPE_INTEGER,
                'updated_at' => Schema::TYPE_INTEGER,
                'PRIMARY KEY (`account_id`, `key`)',
                'FOREIGN KEY (account_id) REFERENCES {{%account}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('{{%account_property}}');
    }
}