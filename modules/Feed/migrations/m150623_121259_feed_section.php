<?php

use yii\db\Schema;

class m150623_121259_feed_section extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%feed_section}}', [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER,
            'slug' => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
            'meta' => Schema::TYPE_TEXT,
            'sort' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            'published_at' => Schema::TYPE_INTEGER,
            'archived_at' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'deleted_at' => Schema::TYPE_INTEGER,
            'activated_at' => Schema::TYPE_INTEGER,
            'FOREIGN KEY (parent_id) REFERENCES {{%feed_section}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->createIndex('idx_slug', '{{%feed_section}}', ['slug'], true);
        $this->createIndex('idx_sort', '{{%feed_section}}', ['sort']);
        $this->createIndex('idx_published_at', '{{%feed_section}}', ['published_at']);
        $this->createIndex('idx_archived_at', '{{%feed_section}}', ['archived_at']);
        $this->createIndex('idx_activated_at', '{{%feed_section}}', ['activated_at']);
        $this->createIndex('idx_deleted_at', '{{%feed_section}}', ['deleted_at']);
        $this->createIndex('idx_published', '{{%feed_section}}', ['published_at', 'archived_at', 'activated_at', 'deleted_at']);
    }

    public function down()
    {
        $this->dropTable('{{%feed_section}}');
    }
}