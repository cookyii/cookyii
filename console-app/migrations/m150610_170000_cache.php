<?php

class m150610_170000_cache extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%cache}}', [
            'id' => $this->string(128)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
            'PRIMARY KEY ([[id]])',
        ]);

        $this->createIndex('idx_cache_expire', '{{%cache}}', ['expire']);
    }

    public function down()
    {
        $this->dropTable('{{%cache}}');
    }
}