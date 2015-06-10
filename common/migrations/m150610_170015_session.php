<?php

use yii\db\mysql\Schema;

class m150610_170015_session extends \common\components\Migration
{

    public function up()
    {
        $this->createTable('{{%session}}', [
            'id' => 'CHAR(40) NOT NULL  PRIMARY KEY',
            'expire' => Schema::TYPE_INTEGER,
            'data' => 'LONGBLOB',
        ]);

        $this->createIndex('idx_expire', '{{%session}}', ['expire']);
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
    }
}
