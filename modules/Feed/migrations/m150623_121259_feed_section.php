<?php

class m150623_121259_feed_section extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%feed_section}}', [
            'schema' => [
                'id' => $this->primaryKey(),
                'parent_id' => $this->integer(),
                'slug' => $this->string(),
                'title' => $this->string(),
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
                'idx_parent' => ['parent_id'],
                'idx_sort' => ['sort'],
                'idx_published_at' => ['published_at'],
                'idx_archived_at' => ['archived_at'],
                'idx_activated_at' => ['activated_at'],
                'idx_deleted_at' => ['deleted_at'],
                'idx_available' => ['published_at', 'archived_at', 'activated_at', 'deleted_at'],
            ],
            'fkeys' => [
                'fkey_feed_section_parent' => [
                    'from' => 'parent_id',
                    'to' => ['{{%feed_section}}', 'id'],
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ],
            ],
        ]);
    }

    public function down()
    {
        $this->dropForeignKey('fkey_feed_section_parent', '{{%feed_section}}');

        $this->dropTable('{{%feed_section}}');
    }
}
