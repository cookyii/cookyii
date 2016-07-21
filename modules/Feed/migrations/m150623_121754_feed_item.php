<?php

class m150623_121754_feed_item extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%feed_item}}', [
            'schema' => [
                'id' => $this->primaryKey(),
                'slug' => $this->string(),
                'title' => $this->string(),
                'picture_media_id' => $this->integer(),
                'content_preview' => $this->text(),
                // @todo in yii version 2.0.9 replace to `$this->mediumText()`
                'content_detail' => 'MEDIUMTEXT',
                'meta' => $this->text(),
                'sort' => $this->integer(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
                'published_at' => $this->unixTimestamp(),
                'archived_at' => $this->unixTimestamp(),
                'activated_at' => $this->unixTimestamp(),
                'created_at' => $this->unixTimestamp(),
                'updated_at' => $this->unixTimestamp(),
                'deleted_at' => $this->unixTimestamp(),
            ],
            'uniques' => [
                'idx_slug' => ['slug(190)'],
            ],
            'indexes' => [
                'idx_sort' => ['sort'],
                'idx_picture_media' => ['picture_media_id'],
                'idx_published_at' => ['published_at'],
                'idx_archived_at' => ['archived_at'],
                'idx_activated_at' => ['activated_at'],
                'idx_deleted_at' => ['deleted_at'],
                'idx_available' => ['published_at', 'archived_at', 'activated_at', 'deleted_at'],
            ],
            'fkeys' => [
                'fkey_feed_item_media' => [
                    'from' => 'picture_media_id',
                    'to' => ['{{%media}}', 'id'],
                    'delete' => 'SET NULL',
                    'update' => 'CASCADE',
                ],
            ],
        ]);

        $this->createTable('{{%feed_item_section}}', [
            'pkey' => ['item_id', 'section_id'],
            'schema' => [
                'item_id' => $this->integer(),
                'section_id' => $this->integer(),
            ],
            'indexes' => [
                'idx_item' => ['item_id'],
                'idx_section' => ['section_id'],
            ],
            'fkeys' => [
                'fkey_feed_item_section_item' => [
                    'from' => 'item_id',
                    'to' => ['{{%feed_item}}', 'id'],
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ],
                'fkey_feed_item_section_section' => [
                    'from' => 'section_id',
                    'to' => ['{{%feed_section}}', 'id'],
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ],
            ],
        ]);
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