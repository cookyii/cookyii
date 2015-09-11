<?php

use yii\db\Schema;

class m150911_205121_client_account_id extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%client}}', 'account_id', Schema::TYPE_INTEGER . ' AFTER [[id]]');
    }

    public function down()
    {
        $this->dropColumn('{{%client}}', 'account_id');
    }
}