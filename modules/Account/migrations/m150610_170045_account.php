<?php

class m150610_170045_account extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%account}}', [
            'schema' => [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'email' => $this->string(),
                'avatar' => $this->string(),
                'password_hash' => $this->string()->notNull(),
                'token' => $this->string(32)->notNull(),
                'auth_key' => $this->string(32)->notNull(),
                'activated_at' => $this->unixTimestamp(),
                'created_at' => $this->unixTimestamp(),
                'updated_at' => $this->unixTimestamp(),
                'deleted_at' => $this->unixTimestamp(),
            ],
            'indexes' => [
                'idx_email' => ['email'],
                'idx_token' => ['token'],
                'idx_auth_key' => ['auth_key'],
                'idx_available' => ['activated_at', 'deleted_at'],
            ],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%account}}');
    }
}