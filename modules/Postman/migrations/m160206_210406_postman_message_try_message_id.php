<?php

use yii\db\Schema;

class m160206_210406_postman_message_try_message_id extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%postman_message}}', 'executed_at', Schema::TYPE_INTEGER . ' AFTER [[scheduled_at]]');
        $this->addColumn('{{%postman_message}}', 'try_message_id', Schema::TYPE_INTEGER . ' AFTER [[address]]');

        $this->createIndex('idx_try_message_id', '{{%postman_message}}', ['try_message_id']);
        $this->createIndex('idx_executed_at', '{{%postman_message}}', ['executed_at']);
    }

    public function down()
    {
        $this->dropColumn('{{%postman_message}}', 'try_message_id');
        $this->dropColumn('{{%postman_message}}', 'executed_at');
    }
}