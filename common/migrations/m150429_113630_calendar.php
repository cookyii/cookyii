<?php

use yii\db\mysql\Schema;

class m150429_113630_calendar extends \common\components\Migration
{

    public function safeUp()
    {
        $this->createTable('{{%calendar}}', [
            'id' => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
            'token' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            'deleted' => Schema::TYPE_BOOLEAN,
            'PRIMARY KEY (id)',
        ]);

        $this->createTable('{{%calendar_event}}', [
            'id' => Schema::TYPE_STRING,
            'calendar_id' => Schema::TYPE_STRING,
            'entity' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            'deleted' => Schema::TYPE_BOOLEAN,
            'PRIMARY KEY (id)',
            'FOREIGN KEY (calendar_id) REFERENCES {{%calendar}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%calendar_event}}');
        $this->dropTable('{{%calendar}}');
    }
}