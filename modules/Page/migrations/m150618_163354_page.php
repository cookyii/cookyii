<?php

use yii\db\mysql\Schema;

class m150618_163354_page extends \cookyii\db\Migration
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
            'deleted_at' => Schema::TYPE_INTEGER,
            'activated_at' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
    }
}