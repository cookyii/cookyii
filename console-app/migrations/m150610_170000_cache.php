<?php

class m150610_170000_cache extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%cache}}', [
            'pkey' => ['id'],
            'schema' => [
                'id' => $this->string(128)->notNull(),
                'expire' => $this->unixTimestamp(),
                'data' => $this->binary(),
            ],
            'indexes' => [
                'idx_expire' => ['expire'],
            ],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%cache}}');
    }
}
