<?php

class m150610_170130_media extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%media}}', [
            'id' => $this->primaryKey(),
            'origin_name' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'mime' => $this->string()->notNull(),
            'size' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0),
            'sha1' => $this->string(40)->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('idx_media_sha', '{{%media}}', ['sha1']);
    }

    public function down()
    {
        $this->dropTable('{{%media}}');
    }
}