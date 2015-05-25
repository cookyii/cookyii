<?php

use yii\db\mysql\Schema;

class m150428_123235_order_delivery_cost extends \common\components\Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'delivery_cost', Schema::TYPE_INTEGER . ' AFTER [[cost]]');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'delivery_cost');
    }
}