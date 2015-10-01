<?php

use yii\db\Schema;

class m151001_203122_account_gender extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%account}}', 'gender', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1 AFTER [[avatar]]');
    }

    public function down()
    {
        $this->dropColumn('{{%account}}', 'gender');
    }
}