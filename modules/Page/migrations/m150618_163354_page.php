<?php

class m150618_163354_page extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%page}}', [
            'schema' => [
                'id' => $this->primaryKey(),
                'slug' => $this->string(),
                'title' => $this->string(),
                // @todo in yii version 2.0.9 replace to `$this->mediumText()`
                'content' => 'MEDIUMTEXT',
                'meta' => $this->text(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
                'activated_at' => $this->unixTimestamp(),
                'created_at' => $this->unixTimestamp(),
                'updated_at' => $this->unixTimestamp(),
                'deleted_at' => $this->unixTimestamp(),
            ],
            'uniques' => [
                'idx_slug' => ['slug(190)'],
            ],
            'indexes' => [
                'idx_activated_at' => ['activated_at'],
                'idx_deleted_at' => ['deleted_at'],
                'idx_available' => ['activated_at', 'deleted_at'],
            ],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
    }
}