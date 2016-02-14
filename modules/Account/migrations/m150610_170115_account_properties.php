<?php

class m150610_170115_account_properties extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%account_property}}', [
            'account_id' => $this->integer(),
            'key' => $this->string()->notNull(),
            'value' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY ([[account_id]], [[key]])',
        ]);

        $this->addForeignKey('fkey_account_property_account', '{{%account_property}}', 'account_id', '{{%account}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fkey_account_property_account', '{{%account_property}}');

        $this->dropTable('{{%account_property}}');
    }
}