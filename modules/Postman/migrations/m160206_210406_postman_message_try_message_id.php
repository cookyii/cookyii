<?php

class m160206_210406_postman_message_try_message_id extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%postman_message}}', 'executed_at', $this->integer() . $this->after('scheduled_at'));
        $this->addColumn('{{%postman_message}}', 'try_message_id', $this->integer() . $this->after('address'));

        $this->createIndex('idx_postman_m_try_message_id', '{{%postman_message}}', ['try_message_id']);
        $this->createIndex('idx_postman_m_executed_at', '{{%postman_message}}', ['executed_at']);
    }

    public function down()
    {
        $this->dropColumn('{{%postman_message}}', 'try_message_id');
        $this->dropColumn('{{%postman_message}}', 'executed_at');
    }
}