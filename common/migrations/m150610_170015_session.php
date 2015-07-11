<?php

use yii\db\mysql\Schema;

class m150610_170015_session extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%session}}', [
            'id' => 'CHAR(40) NOT NULL',
            'expire' => Schema::TYPE_INTEGER,
            'data' => 'LONGBLOB',
            'PRIMARY KEY (id)',
        ]);

        $this->createIndex('idx_expire', '{{%session}}', ['expire']);
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
    }
}
