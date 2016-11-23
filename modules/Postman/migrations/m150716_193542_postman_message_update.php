<?php

class m150716_193542_postman_message_update extends \cookyii\db\Migration
{

    public function up()
    {
        $this->dropColumn('{{%postman_message}}', 'status');
        $this->addColumn('{{%postman_message}}', 'scheduled_at', $this->unixTimestamp()->after('created_at'));
        $this->addColumn('{{%postman_message}}', 'error', $this->text()->after('code'));

        $this->createIndex('idx_scheduled_at', '{{%postman_message}}', ['scheduled_at']);
    }

    public function down()
    {
        $this->dropColumn('{{%postman_message}}', 'error');
        $this->dropColumn('{{%postman_message}}', 'scheduled_at');
        $this->addColumn('{{%postman_message}}', 'status', $this->smallInteger()->after('address'));
    }
}
