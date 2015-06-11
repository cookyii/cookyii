<?php

use yii\db\mysql\Schema;

class m150610_170045_user extends \common\components\Migration
{

    static $socials = ['facebook', 'github', 'google', 'linkedin', 'live', 'twitter', 'vkontakte', 'yandex'];

    public function up()
    {
        $this->createTable(
            '{{%user}}',
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

        $this->createIndex('idx_email', '{{%user}}', ['email']);
        $this->createIndex('idx_token', '{{%user}}', ['token']);
        $this->createIndex('idx_auth_key', '{{%user}}', ['auth_key']);
        $this->createIndex('idx_working', '{{%user}}', ['activated', 'deleted']);

        $this->createTable(
            '{{%user_attribute}}',
            [
                'user_id' => Schema::TYPE_INTEGER,
                'key' => Schema::TYPE_STRING,
                'value_str' => Schema::TYPE_STRING,
                'value_int' => Schema::TYPE_INTEGER,
                'value_float' => Schema::TYPE_DECIMAL . '(10,6)',
                'value_text' => Schema::TYPE_TEXT,
                'value_blob' => Schema::TYPE_BINARY,
                'FOREIGN KEY (user_id) REFERENCES {{%user}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            ]
        );

        $this->createIndex('idx_key', '{{%user_attribute}}', ['key']);
        $this->createIndex('idx_user_id_key', '{{%user_attribute}}', ['user_id', 'key']);

        $this->createTable('{{%user_auth_response}}', [
            'id' => Schema::TYPE_PK,
            'user_ip' => Schema::TYPE_INTEGER,
            'received_at' => Schema::TYPE_INTEGER,
            'client' => Schema::TYPE_STRING,
            'response' => Schema::TYPE_TEXT,
            'result' => Schema::TYPE_TEXT,
        ]);

        $this->createIndex('idx_received_at', '{{%user_auth_response}}', ['received_at']);

        foreach (static::$socials as $social) {
            $this->createTable('{{%user_auth_' . $social . '}}', [
                'user_id' => Schema::TYPE_INTEGER,
                'social_id' => Schema::TYPE_STRING,
                'PRIMARY KEY (user_id, social_id)',
                'FOREIGN KEY (user_id) REFERENCES {{%user}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            ]);
        }
    }

    public function down()
    {
        foreach (static::$socials as $social) {
            $this->dropTable('{{%user_auth_' . $social . '}}');
        }

        $this->dropTable('{{%user_auth_response}}');
        $this->dropTable('{{%user_attribute}}');
        $this->dropTable('{{%user}}');
    }
}