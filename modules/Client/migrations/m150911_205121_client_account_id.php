<?php

class m150911_205121_client_account_id extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%client}}', 'account_id', $this->integer()->after('id'));

        $this->createIndex('idx_account', '{{%client}}', ['account_id']);
    }

    public function down()
    {
        $this->dropColumn('{{%client}}', 'account_id');
    }
}