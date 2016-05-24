<?php

class m160524_182750_account_password_can_be_null extends \cookyii\db\Migration
{

    public function up()
    {
        $this->alterColumn('{{%account}}', 'password_hash', $this->string());
    }

    public function down()
    {
        $this->alterColumn('{{%account}}', 'password_hash', $this->string()->notNull());
    }
}