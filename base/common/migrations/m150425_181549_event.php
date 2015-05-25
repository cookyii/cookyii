<?php

use yii\db\mysql\Schema;

class m150425_181549_event extends \common\components\Migration
{

    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
            'discount_type' => 'TINYINT(2) NOT NULL DEFAULT 0',
            'value' => Schema::TYPE_INTEGER,
            'start_time' => Schema::TYPE_INTEGER,
            'end_time' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ]);

        $this->createTable('{{%event_coupon}}', [
            'id' => Schema::TYPE_PK,
            'event_id' => Schema::TYPE_INTEGER,
            'code' => Schema::TYPE_STRING,
            'limit' => Schema::TYPE_INTEGER,
            'expired' => Schema::TYPE_INTEGER,
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'FOREIGN KEY (event_id) REFERENCES {{%event}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->createIndex('idx_code', '{{%event_coupon}}', ['code']);

        $this->createTable('{{%event_coupon_order}}', [
            'order_id' => Schema::TYPE_INTEGER,
            'coupon_id' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (order_id, coupon_id)',
            'FOREIGN KEY (order_id) REFERENCES {{%order}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (coupon_id) REFERENCES {{%event_coupon}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%event_coupon_order}}');
        $this->dropTable('{{%event_coupon}}');
        $this->dropTable('{{%event}}');
    }
}