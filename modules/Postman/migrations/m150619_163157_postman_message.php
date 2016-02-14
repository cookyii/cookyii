<?php

class m150619_163157_postman_message extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%postman_message}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(),
            'content_text' => $this->text(),
            'content_html' => $this->text(),
            'address' => $this->text(),
            'status' => $this->smallInteger(),
            'code' => $this->string(32),
            'created_at' => $this->integer(),
            'sent_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->createTable('{{%postman_message_attach}}', [
            'message_id' => $this->integer(),
            'media_id' => $this->integer(),
            'embed' => $this->boolean(),
            'FOREIGN KEY (message_id) REFERENCES {{%postman_message}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (media_id) REFERENCES {{%media}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->addPrimaryKey('primary', '{{%postman_message_attach}}', ['message_id', 'media_id']);

        $this->addForeignKey('fkey_postman_message_attach_message', '{{%postman_message_attach}}', 'message_id', '{{%postman_message}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fkey_postman_message_attach_media', '{{%postman_message_attach}}', 'media_id', '{{%media}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fkey_postman_message_attach_media', '{{%postman_message_attach}}');
        $this->dropForeignKey('fkey_postman_message_attach_message', '{{%postman_message_attach}}');

        $this->dropTable('{{%postman_message_attach}}');
        $this->dropTable('{{%postman_message}}');
    }
}