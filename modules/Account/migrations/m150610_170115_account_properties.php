<?php

class m150610_170115_account_properties extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%account_property}}', [
            'schema' => [
                'account_id' => $this->integer(),
                'key' => $this->string(128)->notNull(),
                'value' => $this->text(),
                'created_at' => $this->unixTimestamp(),
                'updated_at' => $this->unixTimestamp(),
                'PRIMARY KEY ([[account_id]], [[key]])',
            ],
            'indexes' => [
                'idx_account' => ['account_id'],
                'idx_key' => ['key'],
            ],
            'fkeys' => [
                'fkey_account_property_account' => [
                    'from' => 'account_id',
                    'to' => ['{{%account}}', 'id'],
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ],
            ],
        ]);
    }

    public function down()
    {
        $this->dropForeignKey('fkey_account_property_account', '{{%account_property}}');

        $this->dropTable('{{%account_property}}');
    }
}
