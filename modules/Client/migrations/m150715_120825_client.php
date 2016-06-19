<?php

class m150715_120825_client extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%client}}', [
            'schema' => [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'email' => $this->string(),
                'phone' => $this->string(),
                'created_at' => $this->unixTimestamp(),
                'updated_at' => $this->unixTimestamp(),
                'deleted_at' => $this->unixTimestamp(),
            ],
            'indexes' => [
                'idx_email' => ['email'],
                'idx_deleted_at' => ['deleted_at'],
            ],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%client}}');
    }
}