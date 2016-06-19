<?php

class m150610_170130_media extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%media}}', [
            'schema' => [
                'id' => $this->primaryKey(),
                'origin_name' => $this->string()->notNull(),
                'name' => $this->string()->notNull(),
                'mime' => $this->string()->notNull(),
                'size' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0),
                'sha1' => $this->string(40)->notNull(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
                'created_at' => $this->unixTimestamp(),
                'updated_at' => $this->unixTimestamp(),
            ],
            'indexes' => [
                'idx_sha' => ['sha1'],
            ],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%media}}');
    }
}