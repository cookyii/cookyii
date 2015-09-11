<?php

use yii\db\Schema;

class m150715_120825_client extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%client}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING,
            'phone' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'deleted_at' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%client}}');
    }
}