<?php

use yii\db\mysql\Schema;

class m150429_113643_order_update extends \common\components\Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'price', Schema::TYPE_INTEGER . ' AFTER [[coupon]]');
        $this->addColumn('{{%order}}', 'prepayment_value', Schema::TYPE_INTEGER . ' AFTER [[prepayment]]');
        $this->addColumn('{{%order}}', 'number', Schema::TYPE_STRING . ' AFTER [[id]]');
        $this->addColumn('{{%order}}', 'synchronized_at', Schema::TYPE_INTEGER . ' AFTER [[target_at]]');

        $orders = \resources\Order::find()
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->all($this->db);

        $counter = [];
        foreach ($orders as $order) {
            $date = Formatter()->asDate($order['created_at'], 'yyMM');

            if (!isset($counter[$date])) {
                $counter[$date] = 0;
            }

            $counter[$date]++;

            $number = str_pad($counter[$date], 4, '0', STR_PAD_LEFT) . $date;

            $this->update(
                '{{%order}}',
                [
                    'number' => $number,
                    'price' => $order['cost'],
                ],
                ['id' => $order['id']]
            );
        }
    }

    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'synchronized_at');
        $this->dropColumn('{{%order}}', 'number');
        $this->dropColumn('{{%order}}', 'prepayment_value');
        $this->dropColumn('{{%order}}', 'price');
    }
}