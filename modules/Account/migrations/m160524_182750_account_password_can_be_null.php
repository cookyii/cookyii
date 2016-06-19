<?php

class m160524_182750_account_password_can_be_null extends \cookyii\db\Migration
{

    public function up()
    {
        $this->alterColumn('{{%account}}', 'password_hash', $this->string());

        $this->update('{{%account}}', ['password_hash' => null], ['password_hash' => '']);
    }

    public function down()
    {
        $this->update('{{%account}}', ['password_hash' => ''], ['password_hash' => null]);

        $this->alterColumn('{{%account}}', 'password_hash', $this->string()->notNull());
    }
}