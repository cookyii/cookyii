<?php

use yii\db\Schema;

class m0001_media extends \yii\db\Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%media}}', [
            'id' => Schema::TYPE_PK,
            'origin_name' => Schema::TYPE_STRING . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'mime' => Schema::TYPE_STRING . ' NOT NULL',
            'size' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
            'sha1' => Schema::TYPE_STRING . '(40) NOT NULL',
        ], $tableOptions);

        $this->createIndex('idx_sha', '{{%media}}', ['sha1']);
    }

    public function down()
    {
        $this->dropTable('{{%media}}');
    }
}