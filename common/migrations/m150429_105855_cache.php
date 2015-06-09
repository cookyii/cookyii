<?php

use yii\db\mysql\Schema;

class m150429_105855_cache extends \common\components\Migration
{

    public function safeUp()
    {
        $this->createTable('{{%cache}}', [
            'id' => Schema::TYPE_STRING . '(128) NOT NULL',
            'expire' => Schema::TYPE_INTEGER,
            'data' => 'LONGBLOB',
            'PRIMARY KEY (id)',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%cache}}');
    }
}