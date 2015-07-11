<?php

use yii\db\mysql\Schema;

class m150619_163157_postman_message extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%postman_message}}', [
            'id' => Schema::TYPE_PK,
            'subject' => Schema::TYPE_STRING,
            'content_text' => Schema::TYPE_TEXT,
            'content_html' => Schema::TYPE_TEXT,
            'address' => Schema::TYPE_TEXT,
            'status' => Schema::TYPE_SMALLINT,
            'code' => Schema::TYPE_STRING . '(32)',
            'created_at' => Schema::TYPE_INTEGER,
            'sent_at' => Schema::TYPE_INTEGER,
            'deleted_at' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('{{%postman_message_attach}}', [
            'message_id' => Schema::TYPE_INTEGER,
            'media_id' => Schema::TYPE_INTEGER,
            'embed' => Schema::TYPE_BOOLEAN,
            'PRIMARY KEY (`message_id`, `media_id`)',
            'FOREIGN KEY (message_id) REFERENCES {{%postman_message}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (media_id) REFERENCES {{%media}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%postman_message_attach}}');
        $this->dropTable('{{%postman_message}}');
    }
}