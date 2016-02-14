<?php

class m150911_205121_client_account_id extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%client}}', 'account_id', $this->integer() . $this->after('id'));
    }

    public function down()
    {
        $this->dropColumn('{{%client}}', 'account_id');
    }
}