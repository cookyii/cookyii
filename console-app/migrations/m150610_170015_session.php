<?php

class m150610_170015_session extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%session}}', [
            'pkey' => ['id'],
            'schema' => [
                'id' => $this->string(40)->notNull(),
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
        $this->dropTable('{{%session}}');
    }
}
