<?php

use yii\db\mysql\Schema;

class m150623_121259_feed_section extends \components\db\Migration
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
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'published_at' => Schema::TYPE_INTEGER,
            'archived_at' => Schema::TYPE_INTEGER,
            'activated' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'FOREIGN KEY (parent_id) REFERENCES {{%feed_section}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->createIndex('idx_slug', '{{%feed_section}}', ['slug'], true);
        $this->createIndex('idx_sort', '{{%feed_section}}', ['sort']);
        $this->createIndex('idx_published_at', '{{%feed_section}}', ['published_at']);
        $this->createIndex('idx_archived_at', '{{%feed_section}}', ['archived_at']);
        $this->createIndex('idx_activated', '{{%feed_section}}', ['activated']);
        $this->createIndex('idx_deleted', '{{%feed_section}}', ['deleted']);
        $this->createIndex('idx_published', '{{%feed_section}}', ['published_at', 'archived_at', 'activated', 'deleted']);
    }

    public function down()
    {
        $this->dropTable('{{%feed_section}}');
    }
}