<?php

class m151001_203122_account_gender extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%account}}', 'gender', 'TINYINT(2) NOT NULL DEFAULT 1 AFTER [[avatar]]');
    }

    public function down()
    {
        $this->dropColumn('{{%account}}', 'gender');
    }
}