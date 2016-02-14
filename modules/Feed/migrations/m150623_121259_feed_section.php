<?php

class m150623_121259_feed_section extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%feed_section}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'slug' => $this->string(),
            'title' => $this->string(),
            'meta' => $this->text(),
            'sort' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'published_at' => $this->integer(),
            'archived_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
            'activated_at' => $this->integer(),
        ]);

        $this->createIndex('idx_feed_s_slug', '{{%feed_section}}', ['slug'], true);
        $this->createIndex('idx_feed_s_sort', '{{%feed_section}}', ['sort']);
        $this->createIndex('idx_feed_s_published_at', '{{%feed_section}}', ['published_at']);
        $this->createIndex('idx_feed_s_archived_at', '{{%feed_section}}', ['archived_at']);
        $this->createIndex('idx_feed_s_activated_at', '{{%feed_section}}', ['activated_at']);
        $this->createIndex('idx_feed_s_deleted_at', '{{%feed_section}}', ['deleted_at']);
        $this->createIndex('idx_feed_s_published', '{{%feed_section}}', ['published_at', 'archived_at', 'activated_at', 'deleted_at']);

        $this->addForeignKey('fkey_feed_section_parent', '{{%feed_section}}', 'parent_id', '{{%feed_section}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fkey_feed_section_parent', '{{%feed_section}}');

        $this->dropTable('{{%feed_section}}');
    }
}