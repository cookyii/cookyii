<?php

use yii\db\mysql\Schema;

class m150610_170100_account_auth extends \common\components\Migration
{

    static $socials = ['facebook', 'github', 'google', 'linkedin', 'live', 'twitter', 'vkontakte', 'yandex'];

    public function up()
    {
        $this->createTable('{{%account_auth_response}}', [
            'id' => Schema::TYPE_PK,
            'user_ip' => Schema::TYPE_INTEGER,
            'received_at' => Schema::TYPE_INTEGER,
            'client' => Schema::TYPE_STRING,
            'response' => Schema::TYPE_TEXT,
            'result' => Schema::TYPE_TEXT,
        ]);

        $this->createIndex('idx_received_at', '{{%account_auth_response}}', ['received_at']);

        foreach (static::$socials as $social) {
            $this->createTable('{{%account_auth_' . $social . '}}', [
                'account_id' => Schema::TYPE_INTEGER,
                'social_id' => Schema::TYPE_STRING,
                'PRIMARY KEY (`account_id`, `social_id`)',
                'FOREIGN KEY (account_id) REFERENCES {{%account}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            ]);
        }
    }

    public function down()
    {
        foreach (static::$socials as $social) {
            $this->dropTable('{{%account_auth_' . $social . '}}');
        }

        $this->dropTable('{{%account_auth_response}}');
    }
}