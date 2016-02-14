<?php

class m150618_163354_page extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(),
            'title' => $this->string(),
            'content' => $this->longText(),
            'meta' => $this->text(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
            'activated_at' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
    }
}