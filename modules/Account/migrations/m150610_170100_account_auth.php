<?php

class m150610_170100_account_auth extends \cookyii\db\Migration
{

    static $providers = ['facebook', 'github', 'google', 'linkedin', 'live', 'twitter', 'vkontakte', 'yandex'];

    public function up()
    {
        $this->createTable('{{%account_auth_response}}', [
            'id' => $this->primaryKey(),
            'user_ip' => $this->integer(),
            'received_at' => $this->integer(),
            'client' => $this->string(),
            'response' => $this->text(),
            'result' => $this->text(),
        ]);

        $this->createIndex('idx_account_a_r_received_at', '{{%account_auth_response}}', ['received_at']);

        foreach (static::$providers as $provider) {
            $table = '{{%account_auth_' . $provider . '}}';

            $this->createTable($table, [
                'account_id' => $this->integer(),
                'social_id' => $this->string(),
            ]);

            $this->addPrimaryKey('primary', $table, ['account_id','social_id']);

            $this->addForeignKey(sprintf('fkey_account_auth_%s_account', $provider), $table, 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
        }
    }

    public function down()
    {
        foreach (static::$providers as $provider) {
            $table = '{{%account_auth_' . $provider . '}}';

            $this->dropForeignKey(sprintf('fkey_account_auth_%s_account', $provider), $table);

            $this->dropTable($table);
        }

        $this->dropTable('{{%account_auth_response}}');
    }
}