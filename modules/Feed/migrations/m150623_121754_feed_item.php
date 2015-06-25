<?php

use yii\db\mysql\Schema;

class m150623_121754_feed_item extends \components\db\Migration
{

    public function up()
    {
        $this->createTable('{{%feed_item}}', [
            'id' => Schema::TYPE_PK,
            'slug' => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
            'picture_media_id' => Schema::TYPE_INTEGER,
            'content_preview' => Schema::TYPE_TEXT,
            'content_detail' => 'MEDIUMTEXT',
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
            'FOREIGN KEY (picture_media_id) REFERENCES {{%media}} (id) ON DELETE SET NULL ON UPDATE CASCADE',
        ]);

        $this->createIndex('idx_slug', '{{%feed_item}}', ['slug'], true);
        $this->createIndex('idx_sort', '{{%feed_item}}', ['sort']);
        $this->createIndex('idx_published_at', '{{%feed_item}}', ['published_at']);
        $this->createIndex('idx_archived_at', '{{%feed_item}}', ['archived_at']);
        $this->createIndex('idx_activated', '{{%feed_item}}', ['activated']);
        $this->createIndex('idx_deleted', '{{%feed_item}}', ['deleted']);
        $this->createIndex('idx_published', '{{%feed_item}}', ['published_at', 'archived_at', 'activated', 'deleted']);

        $this->createTable('{{%feed_item_section}}', [
            'item_id' => Schema::TYPE_INTEGER,
            'section_id' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (`item_id`, `section_id`)',
            'FOREIGN KEY (item_id) REFERENCES {{%feed_item}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (section_id) REFERENCES {{%feed_section}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%feed_item_section}}');
        $this->dropTable('{{%feed_item}}');
    }
}