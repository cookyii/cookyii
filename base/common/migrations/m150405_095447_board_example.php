<?php

use yii\db\mysql\Schema;

class m150405_095447_board_example extends \common\components\Migration
{

    public function safeUp()
    {
        $this->createTable('{{%board_example}}', [
            'id' => Schema::TYPE_PK,
            'client_id' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'received_at' => Schema::TYPE_INTEGER,
            'FOREIGN KEY (client_id) REFERENCES {{%client}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->createIndex('idx_status', '{{%board_example}}', ['status']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%board_example}}');
    }
}