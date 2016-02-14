<?php

class m150716_193542_postman_message_update extends \cookyii\db\Migration
{

    public function up()
    {
        $this->dropColumn('{{%postman_message}}', 'status');
        $this->addColumn('{{%postman_message}}', 'scheduled_at', $this->integer() . $this->after('created_at'));
        $this->addColumn('{{%postman_message}}', 'error', $this->text() . $this->after('code'));
    }

    public function down()
    {
        $this->dropColumn('{{%postman_message}}', 'error');
        $this->dropColumn('{{%postman_message}}', 'scheduled_at');
        $this->addColumn('{{%postman_message}}', 'status', $this->smallInteger() . $this->after('address'));
    }
}