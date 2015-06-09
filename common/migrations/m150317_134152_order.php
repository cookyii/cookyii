<?php

use yii\db\mysql\Schema;

class m150317_134152_order extends \common\components\Migration
{

    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => Schema::TYPE_PK,
            'client_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING,
            'phone' => Schema::TYPE_STRING,
            'user_ip' => Schema::TYPE_BIGINT,
            'content' => Schema::TYPE_TEXT,
            'address' => Schema::TYPE_TEXT,
            'comment' => Schema::TYPE_TEXT,
            'source' => Schema::TYPE_STRING,
            'coupon' => Schema::TYPE_STRING,
            'cost' => Schema::TYPE_INTEGER,
            'discount' => Schema::TYPE_INTEGER,
            'prepayment' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'payment' => 'TINYINT(1) NOT NULL DEFAULT 0',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER,
            'target_at' => Schema::TYPE_INTEGER,
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'FOREIGN KEY (client_id) REFERENCES {{%client}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->createIndex('idx_status', '{{%order}}', ['status']);
        $this->createIndex('idx_deleted', '{{%order}}', ['deleted']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}