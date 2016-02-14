<?php

class m150610_170015_session extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%session}}', [
            'id' => $this->string(40)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
            'PRIMARY KEY ([[id]])',
        ]);

        $this->createIndex('idx_session_expire', '{{%session}}', ['expire']);
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
    }
}
