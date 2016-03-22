<?php

class m150715_120931_client_properties extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%client_property}}', [
            'client_id' => $this->integer(),
            'key' => $this->string()->notNull(),
            'value' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (client_id) REFERENCES {{%client}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->addPrimaryKey('pk', '{{%client_property}}', ['client_id', 'key']);

        $this->addForeignKey('fkey_client_property_client', '{{%client_property}}', 'client_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fkey_client_property_client', '{{%client_property}}');

        $this->dropTable('{{%client_property}}');
    }
}