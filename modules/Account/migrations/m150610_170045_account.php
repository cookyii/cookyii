<?php

use yii\db\mysql\Schema;

class m150610_170045_account extends \components\db\Migration
{

    public function up()
    {
        $this->createTable(
            '{{%account}}',
            [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING,
                'email' => Schema::TYPE_STRING,
                'avatar' => Schema::TYPE_STRING,
                'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
                'token' => Schema::TYPE_STRING . '(32) NOT NULL',
                'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
                'created_at' => Schema::TYPE_INTEGER,
                'updated_at' => Schema::TYPE_INTEGER,
                'deleted_at' => Schema::TYPE_INTEGER,
                'activated_at' => Schema::TYPE_INTEGER,
            ]
        );

        $this->createIndex('idx_email', '{{%account}}', ['email']);
        $this->createIndex('idx_token', '{{%account}}', ['token']);
        $this->createIndex('idx_auth_key', '{{%account}}', ['auth_key']);
        $this->createIndex('idx_working', '{{%account}}', ['activated_at', 'deleted_at']);
    }

    public function down()
    {
        $this->dropTable('{{%account}}');
    }
}