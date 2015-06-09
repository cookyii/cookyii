<?php

use yii\db\mysql\Schema;

class m150317_103004_user extends \common\components\Migration
{

    static $socials = ['facebook', 'github', 'google', 'linkedin', 'live', 'twitter', 'vkontakte', 'yandex'];

    public function safeUp()
    {
        $this->createTable(
            '{{%user}}',
            [
                'id' => Schema::TYPE_PK,
                'login' => Schema::TYPE_STRING,
                'name' => Schema::TYPE_STRING,
                'email' => Schema::TYPE_STRING,
                'avatar' => Schema::TYPE_STRING,
                'token' => Schema::TYPE_STRING . '(32) NOT NULL',
                'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'activated' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
                'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            ]
        );

        $this->createIndex('idx_email', '{{%user}}', ['email']);
        $this->createIndex('idx_token', '{{%user}}', ['token']);
        $this->createIndex('idx_auth_key', '{{%user}}', ['auth_key']);
        $this->createIndex('idx_working', '{{%user}}', ['activated', 'deleted']);

        $this->createTable('{{%user_auth_response}}', [
            'id' => Schema::TYPE_PK,
            'received_at' => Schema::TYPE_INTEGER,
            'client' => Schema::TYPE_STRING,
            'response' => Schema::TYPE_TEXT,
            'result' => Schema::TYPE_TEXT,
            'user_ip' => Schema::TYPE_BIGINT,
        ]);

        $this->createIndex('idx_received_at', '{{%user_auth_response}}', ['received_at']);

        foreach (static::$socials as $social) {
            $this->createTable('{{%user_auth_' . $social . '}}', [
                'user_id' => Schema::TYPE_INTEGER,
                'social_id' => Schema::TYPE_STRING,
                'PRIMARY KEY (user_id,social_id)',
                'FOREIGN KEY (user_id) REFERENCES {{%user}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            ]);
        }
    }

    public function safeDown()
    {
        foreach (static::$socials as $social) {
            $this->dropTable('{{%user_auth_' . $social . '}}');
        }

        $this->dropTable('{{%user_auth_response}}');
        $this->dropTable('{{%user}}');
    }
}