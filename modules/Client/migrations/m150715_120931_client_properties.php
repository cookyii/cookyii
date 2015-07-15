<?php

use yii\db\mysql\Schema;

class m150715_120931_client_properties extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable(
            '{{%client_property}}',
            [
                'client_id' => Schema::TYPE_INTEGER,
                'key' => Schema::TYPE_STRING . ' NOT NULL',
                'value' => Schema::TYPE_TEXT,
                'created_at' => Schema::TYPE_INTEGER,
                'updated_at' => Schema::TYPE_INTEGER,
                'PRIMARY KEY (`client_id`, `key`)',
                'FOREIGN KEY (client_id) REFERENCES {{%client}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            ]
        );
    }

    public function down()
    {
        $this->dropTable('{{%account_property}}');
    }
}