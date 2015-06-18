<?php

use yii\db\mysql\Schema;

class m150610_170045_account extends \common\components\Migration
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
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'activated' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
                'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            ]
        );

        $this->createIndex('idx_email', '{{%account}}', ['email']);
        $this->createIndex('idx_token', '{{%account}}', ['token']);
        $this->createIndex('idx_auth_key', '{{%account}}', ['auth_key']);
        $this->createIndex('idx_working', '{{%account}}', ['activated', 'deleted']);
    }

    public function down()
    {
        $this->dropTable('{{%account}}');
    }
}