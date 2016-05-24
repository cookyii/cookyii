<?php

class m160221_174717_account_alert extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%account_alert}}', [
            'id' => $this->string(),
            'account_id' => $this->integer(),
            'type' => $this->smallInteger(),
            'message' => $this->string(),
            'detail' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
            'PRIMARY KEY (id)',
        ]);

        $this->addForeignKey(
            'fkey_account_alert_account_id',
            '{{%account_alert}}', 'account_id',
            '{{%account}}', 'id',
            'CASCADE', 'CASCADE'
        );

        $this->createIndex('idx_deleted', '{{%account_alert}}', ['message', 'deleted_at']);
    }

    public function down()
    {
        $this->dropTable('{{%account_alert}}');
    }
}