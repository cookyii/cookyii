<?php

class m150610_170015_session extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%session}}', [
            'schema' => [
                'id' => $this->string(40)->notNull(),
                'expire' => $this->unixTimestamp(),
                'data' => $this->binary(),
            ],
            'pkey' => ['id'],
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
