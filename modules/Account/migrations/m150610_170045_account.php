<?php

class m150610_170045_account extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'email' => $this->string(),
            'avatar' => $this->string(),
            'password_hash' => $this->string()->notNull(),
            'token' => $this->string(32)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
            'activated_at' => $this->integer(),
        ]);

        $this->createIndex('idx_account_email', '{{%account}}', ['email']);
        $this->createIndex('idx_account_token', '{{%account}}', ['token']);
        $this->createIndex('idx_account_auth_key', '{{%account}}', ['auth_key']);
        $this->createIndex('idx_account_working', '{{%account}}', ['activated_at', 'deleted_at']);
    }

    public function down()
    {
        $this->dropTable('{{%account}}');
    }
}