<?php

class m150610_170100_account_auth extends \cookyii\db\Migration
{

    static $providers = ['facebook', 'github', 'google', 'linkedin', 'live', 'twitter', 'vkontakte', 'yandex'];

    public function up()
    {
        $this->createTable('{{%account_auth_response}}', [
            'schema' => [
                'id' => $this->primaryKey(),
                'user_ip' => $this->integer(),
                'received_at' => $this->unixTimestamp(),
                'client' => $this->string(),
                'response' => $this->text(),
                'result' => $this->text(),
            ],
            'indexes' => [
                'idx_received_at' => ['received_at'],
            ],
        ]);

        foreach (static::$providers as $provider) {
            $this->createTable("{{%account_auth_$provider}}", [
                'pkey' => ['account_id', 'social_id'],
                'schema' => [
                    'account_id' => $this->integer(),
                    'social_id' => $this->string(128),
                ],
                'indexes' => [
                    'idx_account' => ['account_id'],
                    'idx_social' => ['social_id'],
                ],
                'fkeys' => [
                    "fkey_account_auth_{$provider}_account" => [
                        'from' => 'account_id',
                        'to' => ['{{%account}}', 'id'],
                        'delete' => 'CASCADE',
                        'update' => 'CASCADE',
                    ],
                ],
            ]);
        }
    }

    public function down()
    {
        foreach (static::$providers as $provider) {
            $table = "{{%account_auth_$provider}}";

            $this->dropForeignKey("fkey_account_auth_{$provider}_account", $table);

            $this->dropTable($table);
        }

        $this->dropTable('{{%account_auth_response}}');
    }
}
