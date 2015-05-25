<?php

use yii\db\Schema;
use yii\helpers\Console;

class m150428_123236_comments extends \common\components\Migration
{

    private $answer = null;

    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => Schema::TYPE_PK,
            'entity' => Schema::TYPE_STRING,
            'text' => Schema::TYPE_TEXT,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ]);

        $this->createIndex('idx_entity', '{{%comment}}', ['entity']);
        $this->createIndex('idx_created_by', '{{%comment}}', ['created_by']);
        $this->createIndex('idx_created_at', '{{%comment}}', ['created_at']);

        $user = \resources\User::find()
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->one($this->db);

        $orders = \resources\Order::find()
            ->where(['not', ['comment' => null]])
            ->asArray()
            ->all($this->db);

        foreach ($orders as $order) {
            $this->insert('{{%comment}}', [
                'entity' => 'order-' . $order['id'],
                'text' => $order['comment'],
                'created_by' => $user['id'],
                'updated_by' => $user['id'],
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        }

        $this->dropColumn('{{%order}}', 'comment');
    }

    public function safeDown()
    {
        if ($this->answer === null) {
            $this->answer = Console::confirm('Откат миграции приведёт к потере данных. Вы уверены?');
        }

        if ($this->answer === true) {
            $this->addColumn('{{%order}}', 'comment', Schema::TYPE_TEXT . ' AFTER [[address]]');

            $this->dropTable('{{%comment}}');
        }

        return $this->answer;
    }
}