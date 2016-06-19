<?php

class m160221_174717_account_alert extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%account_alert}}', [
            'schema' => [
                'id' => $this->string(),
                'account_id' => $this->integer(),
                'type' => $this->smallInteger(),
                'message' => $this->string(),
                'detail' => $this->text(),
                'created_at' => $this->unixTimestamp(),
                'updated_at' => $this->unixTimestamp(),
                'deleted_at' => $this->unixTimestamp(),
                'PRIMARY KEY ([[id]])',
            ],
            'indexes' => [
                'idx_account' => ['account_id'],
                'idx_available' => ['message', 'deleted_at'],
                'idx_deleted_at' => ['deleted_at'],
            ],
            'fkeys' => [
                'fkey_account_alert_account_id' => [
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
        $this->dropForeignKey('fkey_account_alert_account_id', '{{%account_alert}}');

        $this->dropTable('{{%account_alert}}');
    }
}