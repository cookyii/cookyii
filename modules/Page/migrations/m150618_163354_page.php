<?php

use yii\db\mysql\Schema;

class m150618_163354_page extends \components\db\Migration
{

    public function up()
    {
        $this->createTable('{{%page}}', [
            'id' => Schema::TYPE_PK,
            'slug' => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
            'content' => 'LONGTEXT',
            'meta' => Schema::TYPE_TEXT,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'activated' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
    }
}