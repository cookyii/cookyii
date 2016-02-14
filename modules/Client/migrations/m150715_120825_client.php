<?php

class m150715_120825_client extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%client}}');
    }
}