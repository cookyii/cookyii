<?php

class m150715_120931_client_properties extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%client_property}}', [
            'pkey' => ['client_id', 'key'],
            'schema' => [
                'client_id' => $this->integer(),
                'key' => $this->string(128)->notNull(),
                'value' => $this->text(),
                'created_at' => $this->unixTimestamp(),
                'updated_at' => $this->unixTimestamp(),
            ],
            'indexes' => [
                'idx_client' => ['client_id'],
                'idx_key' => ['key'],
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
