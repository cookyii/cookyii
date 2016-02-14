<?php

class m150623_121754_feed_item extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%feed_item}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(),
            'title' => $this->string(),
            'picture_media_id' => $this->integer(),
            'content_preview' => $this->text(),
            'content_detail' => $this->longText(),
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
            'FOREIGN KEY (picture_media_id) REFERENCES {{%media}} (id) ON DELETE SET NULL ON UPDATE CASCADE',
        ]);

        $this->createIndex('idx_feed_i_slug', '{{%feed_item}}', ['slug'], true);
        $this->createIndex('idx_feed_i_sort', '{{%feed_item}}', ['sort']);
        $this->createIndex('idx_feed_i_published_at', '{{%feed_item}}', ['published_at']);
        $this->createIndex('idx_feed_i_archived_at', '{{%feed_item}}', ['archived_at']);
        $this->createIndex('idx_feed_i_activated_at', '{{%feed_item}}', ['activated_at']);
        $this->createIndex('idx_feed_i_deleted_at', '{{%feed_item}}', ['deleted_at']);
        $this->createIndex('idx_feed_i_published', '{{%feed_item}}', ['published_at', 'archived_at', 'activated_at', 'deleted_at']);

        $this->createTable('{{%feed_item_section}}', [
            'item_id' => $this->integer(),
            'section_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('primary', '{{%feed_item_section}}', ['item_id', 'section_id']);

        $this->addForeignKey('fkey_feed_item_media', '{{%feed_item}}', 'picture_media_id', '{{%media}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fkey_feed_item_section_item', '{{%feed_item_section}}', 'item_id', '{{%feed_item}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fkey_feed_item_section_section', '{{%feed_item_section}}', 'section_id', '{{%feed_section}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fkey_feed_item_section_section', '{{%feed_item_section}}');
        $this->dropForeignKey('fkey_feed_item_section_item', '{{%feed_item_section}}');
        $this->dropForeignKey('fkey_feed_item_media', '{{%feed_item}}');

        $this->dropTable('{{%feed_item_section}}');
        $this->dropTable('{{%feed_item}}');
    }
}