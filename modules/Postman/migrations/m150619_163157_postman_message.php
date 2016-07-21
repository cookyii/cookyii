<?php

class m150619_163157_postman_message extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%postman_message}}', [
            'schema' => [
                'id' => $this->primaryKey(),
                'subject' => $this->string(),
                'content_text' => $this->text(),
                'content_html' => $this->text(),
                'address' => $this->text(),
                'status' => $this->smallInteger(),
                'code' => $this->string(32),
                'sent_at' => $this->unixTimestamp(),
                'created_at' => $this->unixTimestamp(),
                'deleted_at' => $this->unixTimestamp(),
            ],
            'indexes' => [
                'idx_code' => ['code'],
                'idx_deleted_at' => ['deleted_at'],
            ],
        ]);

        $this->createTable('{{%postman_message_attach}}', [
            'pkey' => ['message_id', 'media_id'],
            'schema' => [
                'message_id' => $this->integer(),
                'media_id' => $this->integer(),
                'embed' => $this->boolean()->defaultValue(0),
            ],
            'indexes' => [
                'idx_message' => ['message_id'],
                'idx_media' => ['media_id'],
            ],
            'fkeys' => [
                'fkey_postman_message_attach_message' => [
                    'from' => 'message_id',
                    'to' => ['{{%postman_message}}', 'id'],
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ],
                'fkey_postman_message_attach_media' => [
                    'from' => 'media_id',
                    'to' => ['{{%media}}', 'id'],
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ],
            ],
        ]);
    }

    public function down()
    {
        $this->dropForeignKey('fkey_postman_message_attach_media', '{{%postman_message_attach}}');
        $this->dropForeignKey('fkey_postman_message_attach_message', '{{%postman_message_attach}}');

        $this->dropTable('{{%postman_message_attach}}');
        $this->dropTable('{{%postman_message}}');
    }
}