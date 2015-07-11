<?php

use yii\db\Schema;

class m150610_170130_media extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%media}}', [
            'id' => Schema::TYPE_PK,
            'origin_name' => Schema::TYPE_STRING . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'mime' => Schema::TYPE_STRING . ' NOT NULL',
            'size' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
            'sha1' => Schema::TYPE_STRING . '(40) NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ]);

        $this->createIndex('idx_sha', '{{%media}}', ['sha1']);
    }

    public function down()
    {
        $this->dropTable('{{%media}}');
    }
}