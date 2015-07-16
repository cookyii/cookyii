<?php

use yii\db\mysql\Schema;

class m150716_193542_postman_message_update extends \cookyii\db\Migration
{

    public function up()
    {
        $this->dropColumn('{{%postman_message}}', 'status');
        $this->addColumn('{{%postman_message}}', 'scheduled_at', Schema::TYPE_INTEGER . ' AFTER [[created_at]]');
        $this->addColumn('{{%postman_message}}', 'error', Schema::TYPE_TEXT . ' AFTER [[code]]');
    }

    public function down()
    {
        $this->dropColumn('{{%postman_message}}', 'error');
        $this->dropColumn('{{%postman_message}}', 'scheduled_at');
        $this->addColumn('{{%postman_message}}', 'status', Schema::TYPE_SMALLINT . ' AFTER [[address]]');
    }
}