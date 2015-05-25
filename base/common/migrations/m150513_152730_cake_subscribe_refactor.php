<?php

use yii\db\mysql\Schema;
use yii\helpers\ArrayHelper;

class m150513_152730_cake_subscribe_refactor extends \common\components\Migration
{

    public function safeUp()
    {
        $this->renameTable('{{%cake_subscribe}}', '{{%cake_subscriber}}');

        $this->addColumn('{{%cake_subscriber}}', 'token', Schema::TYPE_STRING . ' AFTER [[email]]');
        $this->addColumn('{{%cake_subscriber}}', 'activated', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0');
        $this->addColumn('{{%cake_subscriber}}', 'deleted', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0');

        $this->createIndex('idx_activated', '{{%cake_subscriber}}', ['activated']);
        $this->createIndex('idx_deleted', '{{%cake_subscriber}}', ['deleted']);

        $subscribers = (new \yii\db\Query())
            ->select('*')
            ->from('{{%cake_subscriber}}')
            ->all();

        $subscriber_clients_id = ArrayHelper::getColumn($subscribers, 'client_id');

        if (!empty($subscribers)) {
            foreach ($subscribers as $subscriber) {
                $this->update(
                    '{{%cake_subscriber}}',
                    [
                        'token' => Security()->generateRandomString(),
                        'activated' => 1
                    ], [
                        'id' => $subscriber['id']
                    ]
                );
            }
        }

        $condition = ['or', ['email' => null], ['email' => '']];

        if (!empty($subscriber_clients_id)) {
            $condition[] = ['id' => $subscriber_clients_id];
        }

        $clients = (new \yii\db\Query())
            ->select('*')
            ->from('{{%client}}')
            ->andWhere(['not', $condition])
            ->all();

        if (!empty($clients)) {
            foreach ($clients as $client) {
                $this->insert('{{%cake_subscriber}}', [
                    'client_id' => $client['id'],
                    'email' => $client['email'],
                    'token' => Security()->generateRandomString(),
                    'subscribed_at' => time(),
                    'activated' => 1,
                ]);
            }
        }
    }

    public function safeDown()
    {
        $this->dropColumn('{{%cake_subscriber}}', 'deleted');
        $this->dropColumn('{{%cake_subscriber}}', 'activated');
        $this->dropColumn('{{%cake_subscriber}}', 'token');

        $this->renameTable('{{%cake_subscriber}}', '{{%cake_subscribe}}');
    }
}