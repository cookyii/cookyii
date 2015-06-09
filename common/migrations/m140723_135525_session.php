<?php

use yii\db\mysql\Schema;

class m140723_135525_session extends \common\components\Migration
{

    public function safeUp()
    {
        $this->createTable('{{%session}}', [
            'id' => 'CHAR(40) NOT NULL  PRIMARY KEY',
            'expire' => Schema::TYPE_INTEGER,
            'data' => 'LONGBLOB',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%session}}');
    }
}
