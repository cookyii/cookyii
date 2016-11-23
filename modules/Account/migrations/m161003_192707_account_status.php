<?php

class m161003_192707_account_status extends \cookyii\db\Migration
{

    public function up()
    {
        $this->addColumn('{{%account}}', 'status', $this->smallInteger()->defaultValue(0)->after('timezone'));

        $this->createIndex('idx_status', '{{%account}}', ['status']);
    }

    public function down()
    {
        $this->dropColumn('{{%account}}', 'status');
    }
}
