<?php

class m150520_142015_order_status_rearrange extends \common\components\Migration
{

    public function safeUp()
    {
        $this->flipStatus();
    }

    public function safeDown()
    {
        $this->flipStatus();
    }

    private function flipStatus()
    {
        $orders = (new \yii\db\Query())
            ->select('*')
            ->from('{{%order}}')
            ->all();

        if (!empty($orders)) {
            foreach ($orders as $order) {
                if ($order['status'] === '100') {
                    $this->update(
                        '{{%order}}',
                        ['status' => 200],
                        ['id' => $order['id']]
                    );
                }

                if ($order['status'] === '200') {
                    $this->update(
                        '{{%order}}',
                        ['status' => 100],
                        ['id' => $order['id']]
                    );
                }
            }
        }
    }
}