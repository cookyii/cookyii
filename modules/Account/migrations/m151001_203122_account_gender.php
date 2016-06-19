<?php

class m151001_203122_account_gender extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%account}}', 'gender', $this->smallInteger(2)->notNull()->defaultValue(1)->after('avatar'));
    }

    public function down()
    {
        $this->dropColumn('{{%account}}', 'gender');
    }
}