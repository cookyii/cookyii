<?php

class m150715_120931_client_properties extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%client_property}}', [
            'schema' => [
                'client_id' => $this->integer(),
                'key' => $this->string()->notNull(),
                'value' => $this->text(),
                'created_at' => $this->unixTimestamp(),
                'updated_at' => $this->unixTimestamp(),
                'PRIMARY KEY ([[client_id]], [[key]])',
            ],
            'indexes' => [
                'idx_client' => ['client_id'],
            ],
            'fkeys' => [
                'fkey_client_property_client' => [
                    'from' => 'client_id',
                    'to' => ['{{%client}}', 'id'],
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ],
            ],
        ]);
    }

    public function down()
    {
        $this->dropForeignKey('fkey_client_property_client', '{{%client_property}}');

        $this->dropTable('{{%client_property}}');
    }
}