<?php

class m181021_183853_postman_embed_id extends \cookyii\db\Migration
{
    public function up()
    {
        $this->alterColumn('{{%postman_message_attach}}', 'embed', $this->string()->null());
    }

    public function down()
    {
        $this->alterColumn('{{%postman_message_attach}}', 'embed', $this->boolean()->defaultValue(0));
    }
}