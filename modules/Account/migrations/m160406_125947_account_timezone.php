<?php

class m160406_125947_account_timezone extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%account}}', 'timezone', $this->smallInteger()->after('gender'));
    }

    public function down()
    {
        $this->dropColumn('{{%account}}', 'timezone');
    }
}