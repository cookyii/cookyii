<?php

use yii\db\mysql\Schema;

class m150405_101251_cake_subscribe extends \common\components\Migration
{

    public function safeUp()
    {
        $this->createTable('{{%cake_subscribe}}', [
            'id' => Schema::TYPE_PK,
            'client_id' => Schema::TYPE_INTEGER,
            'email' => Schema::TYPE_STRING,
            'subscribed_at' => Schema::TYPE_INTEGER,
            'unsubscribed_at' => Schema::TYPE_INTEGER,
            'FOREIGN KEY (client_id) REFERENCES {{%client}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->createIndex('idx_email', '{{%cake_subscribe}}', ['email']);
        $this->createIndex('idx_subscribed_at', '{{%cake_subscribe}}', ['subscribed_at']);
        $this->createIndex('idx_unsubscribed_at', '{{%cake_subscribe}}', ['unsubscribed_at']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%cake_subscribe}}');
    }
}