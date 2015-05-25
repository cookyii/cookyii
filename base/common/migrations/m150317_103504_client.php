<?php

use yii\db\mysql\Schema;

class m150317_103504_client extends \common\components\Migration
{

    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING,
            'phone' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ]);

        $this->createIndex('idx_email', '{{%client}}', ['email']);
        $this->createIndex('idx_phone', '{{%client}}', ['phone']);
        $this->createIndex('idx_deleted', '{{%client}}', ['deleted']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}