<?php

class m150623_151118_feed_demo_data extends \cookyii\db\Migration
{

    public function up()
    {
        if (!YII_DEMO_DATA) {
            echo "    > m150623_151118_feed_demo_data skipped.\n";

            return true;
        }

        $section_id = $this->insertSection([
            'parent_id' => null,
            'slug' => 'news',
            'title' => 'News',
            'sort' => 100,
        ]);

        $item_id = $this->insertItem([
            'slug' => 'first-news',
            'title' => 'First news',
            'content_preview' => $this->getFakerTextBlock(1, [100, 200]),
            'content_detail' => $this->getFakerTextBlock(3, [400, 600]),
            'sort' => 100,
        ]);

        $this->link($item_id, $section_id);

        $item_id = $this->insertItem([
            'slug' => 'second-news',
            'title' => 'Second news',
            'content_preview' => $this->getFakerTextBlock(1, [100, 200]),
            'content_detail' => $this->getFakerTextBlock(3, [400, 600]),
            'sort' => 200,
        ]);

        $this->link($item_id, $section_id);

        $item_id = $this->insertItem([
            'slug' => 'third-news',
            'title' => 'Third news',
            'content_preview' => $this->getFakerTextBlock(1, [100, 200]),
            'content_detail' => $this->getFakerTextBlock(3, [400, 600]),
            'sort' => 300,
        ]);

        $this->link($item_id, $section_id);

        $parent_section_id = $this->insertSection([
            'parent_id' => null,
            'slug' => 'articles',
            'title' => 'Articles',
            'sort' => 200,
        ]);

        $item_id = $this->insertItem([
            'slug' => 'other-article',
            'title' => 'Other article',
            'content_preview' => $this->getFakerTextBlock(1, [100, 200]),
            'content_detail' => $this->getFakerTextBlock(3, [400, 600]),
            'sort' => 100,
        ]);

        $this->link($item_id, $parent_section_id);

        $section_id = $this->insertSection([
            'parent_id' => $parent_section_id,
            'slug' => 'articles-it',
            'title' => 'IT',
            'sort' => 200,
        ]);

        $item_id = $this->insertItem([
            'slug' => 'article-about-it',
            'title' => 'Article about it',
            'content_preview' => $this->getFakerTextBlock(1, [100, 200]),
            'content_detail' => $this->getFakerTextBlock(3, [400, 600]),
            'sort' => 100,
        ]);

        $this->link($item_id, $section_id);

        $item_id = $this->insertItem([
            'slug' => 'other-article-about-it',
            'title' => 'Other article about it',
            'content_preview' => $this->getFakerTextBlock(1, [100, 200]),
            'content_detail' => $this->getFakerTextBlock(3, [400, 600]),
            'sort' => 200,
        ]);

        $this->link($item_id, $section_id);

        $section_id = $this->insertSection([
            'parent_id' => $parent_section_id,
            'slug' => 'articles-photo',
            'title' => 'Photo',
            'sort' => 300,
        ]);

        $item_id = $this->insertItem([
            'slug' => 'article-about-photo',
            'title' => 'Article about photo',
            'content_preview' => $this->getFakerTextBlock(1, [100, 200]),
            'content_detail' => $this->getFakerTextBlock(3, [400, 600]),
            'sort' => 100,
        ]);

        $this->link($item_id, $section_id);

        $section_id = $this->insertSection([
            'parent_id' => $parent_section_id,
            'slug' => 'articles-law',
            'title' => 'Law',
            'sort' => 100,
        ]);

        $item_id = $this->insertItem([
            'slug' => 'article-about-law',
            'title' => 'Article about law',
            'content_preview' => $this->getFakerTextBlock(1, [100, 200]),
            'content_detail' => $this->getFakerTextBlock(3, [400, 600]),
            'sort' => 100,
        ]);

        $this->link($item_id, $section_id);

        $section_id = $this->insertSection([
            'parent_id' => null,
            'slug' => 'faq',
            'title' => 'FAQ',
            'sort' => 300,
        ]);

        $item_id = $this->insertItem([
            'slug' => 'faq-question-1',
            'title' => 'What about tomorrow?',
            'content_preview' => 'What about tomorrow?',
            'content_detail' => 'Maybe!',
            'sort' => 100,
        ]);

        $this->link($item_id, $section_id);

        $item_id = $this->insertItem([
            'slug' => 'faq-question-2',
            'title' => 'Can I go?',
            'content_preview' => 'Can I go?',
            'content_detail' => 'No.',
            'sort' => 200,
        ]);

        $this->link($item_id, $section_id);

        $item_id = $this->insertItem([
            'slug' => 'faq-question-3',
            'title' => 'How much can you?',
            'content_preview' => 'How much can you?',
            'content_detail' => 'Infinitely.',
            'sort' => 300,
        ]);

        $this->link($item_id, $section_id);
    }

    public function down()
    {
        echo "    > m150623_151118_feed_demo_data reverted.\n";

        return true;
    }

    /**
     * @param integer $item_id
     * @param integer $section_id
     */
    private function link($item_id, $section_id)
    {
        $attributes = [
            'item_id' => $item_id,
            'section_id' => $section_id,
        ];

        $exists = (new yii\db\Query)
            ->from('{{%feed_item_section}}')
            ->where($attributes)
            ->exists();

        if (!$exists) {
            $this->insert('{{%feed_item_section}}', $attributes);
        }
    }

    /**
     * @param array $attributes
     * @return int
     */
    private function insertSection(array $attributes)
    {
        return $this->_insert('{{%feed_section}}', $attributes);
    }

    /**
     * @param array $attributes
     * @return int
     */
    private function insertItem(array $attributes)
    {
        return $this->_insert('{{%feed_item}}', $attributes);
    }

    /**
     * @param string $tableName
     * @param array $attributes
     * @return integer
     */
    private function _insert($tableName, array $attributes)
    {
        $row = (new yii\db\Query)
            ->from($tableName)
            ->where(['slug' => $attributes['slug']])
            ->one();

        if (empty($row)) {
            $attributes = array_merge([
                'created_at' => time(),
                'updated_at' => time(),
                'published_at' => time(),
                'activated_at' => time(),
            ], $attributes);

            $this->insert($tableName, $attributes);

            $result = $this->db->getLastInsertID();
        } else {
            $result = $row['id'];
        }

        return $result;
    }
}
