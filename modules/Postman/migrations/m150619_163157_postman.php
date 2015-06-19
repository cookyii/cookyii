<?php

use yii\db\mysql\Schema;

class m150619_163157_postman extends \components\db\Migration
{

    public function up()
    {
        $this->createTable('{{%postman_letter}}', [
            'id' => Schema::TYPE_PK,
            'subject' => Schema::TYPE_STRING,
            'content_text' => Schema::TYPE_TEXT,
            'content_html' => Schema::TYPE_TEXT,
            'address' => Schema::TYPE_TEXT,
            'status' => Schema::TYPE_SMALLINT,
            'created_at' => Schema::TYPE_INTEGER,
            'sent_at' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('{{%postman_letter_attach}}', [
            'letter_id' => Schema::TYPE_INTEGER,
            'media_id' => Schema::TYPE_INTEGER,
            'embed' => Schema::TYPE_BOOLEAN,
            'PRIMARY KEY (`letter_id`, `media_id`)',
            'FOREIGN KEY (letter_id) REFERENCES {{%postman_letter}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (media_id) REFERENCES {{%media}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%postman_letter}}');
        $this->dropTable('{{%postman_letter_attach}}');
    }
}