<?php

class m150623_151118_feed_demo_data extends \cookyii\db\Migration
{

    public function up()
    {
        $lorem = [
            'preview' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nisl erat, vulputate '
                . 'sed laoreet id, dictum non nisl. Donec id diam ligula. Sed nec est eget odio elementum rhoncus. '
                . 'Proin luctus, odio non maximus egestas, ante dui vehicula lorem, a porta ante turpis non elit. '
                . 'Morbi non vestibulum ante.</p>',
            'detail' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nisl erat, vulputate sed '
                . 'laoreet id, dictum non nisl. Donec id diam ligula. Sed nec est eget odio elementum rhoncus. '
                . 'Proin luctus, odio non maximus egestas, ante dui vehicula lorem, a porta ante turpis non elit. '
                . 'Morbi non vestibulum ante. Praesent erat enim, commodo id vestibulum eu, ultricies a neque. '
                . 'Cras egestas orci eu mauris pellentesque, vel malesuada sem porta. In tempus ornare neque. '
                . 'Cras arcu orci, tempus quis eros eget, consectetur cursus justo. Praesent non dui in est porttitor '
                . 'blandit. Phasellus id placerat libero, a porttitor ipsum.</p>' . PHP_EOL
                . '<p>Cras in imperdiet lectus, in pharetra odio. Mauris eget sapien laoreet, euismod ex et, varius '
                . 'urna. Fusce sit amet mi eros. Nam imperdiet lorem quis massa accumsan sagittis et vitae lacus. '
                . 'Sed ultrices urna ac elit pretium, ut venenatis magna dignissim. Pellentesque ultrices, libero '
                . 'at vestibulum imperdiet, augue massa vehicula nisi, a fermentum eros mauris sit amet dolor. '
                . 'Nulla ipsum arcu, interdum at dolor viverra, finibus pretium risus. Nam eget hendrerit ante, '
                . 'in imperdiet ligula.</p>' . PHP_EOL
                . '<p>Fusce nunc metus, ornare sed turpis nec, laoreet pellentesque mauris. Proin ultrices ligula ex, '
                . 'id accumsan libero accumsan vel. Nunc id velit id felis auctor pretium ac ut magna. Nam mattis magna '
                . 'nulla, sed porta dui mollis in. Nullam purus nisl, maximus sed dignissim at, tincidunt vel orci. '
                . 'Vivamus scelerisque ut eros sit amet pulvinar. Integer vel lacinia neque. Nunc sit amet posuere nisi. '
                . 'Curabitur pharetra, quam sed eleifend tincidunt, ante tortor vestibulum ante, sed luctus magna leo '
                . 'nec est. In et faucibus metus, id pellentesque urna. Suspendisse non ante nibh. Maecenas eu rhoncus '
                . 'massa. Phasellus fringilla risus eget massa malesuada elementum. Praesent in felis varius, finibus '
                . 'dui et, dignissim ligula. Nulla vitae mauris ut quam facilisis dictum sit amet id erat. Sed ipsum '
                . 'nunc, feugiat eget iaculis at, euismod eu enim.</p>',
        ];

        $section_id = $this->insertSection([
            'parent_id' => null,
            'slug' => 'news',
            'title' => 'News',
            'sort' => 100,
        ]);

        $item_id = $this->insertItem([
            'slug' => 'first-news',
            'title' => 'First news',
            'content_preview' => $lorem['preview'],
            'content_detail' => $lorem['detail'],
            'sort' => 100,
        ]);

        $this->link($item_id, $section_id);

        $item_id = $this->insertItem([
            'slug' => 'second-news',
            'title' => 'Second news',
            'content_preview' => $lorem['preview'],
            'content_detail' => $lorem['detail'],
            'sort' => 200,
        ]);

        $this->link($item_id, $section_id);

        $item_id = $this->insertItem([
            'slug' => 'third-news',
            'title' => 'Third news',
            'content_preview' => $lorem['preview'],
            'content_detail' => $lorem['detail'],
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
            'content_preview' => $lorem['preview'],
            'content_detail' => $lorem['detail'],
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
            'content_preview' => $lorem['preview'],
            'content_detail' => $lorem['detail'],
            'sort' => 100,
        ]);

        $this->link($item_id, $section_id);

        $item_id = $this->insertItem([
            'slug' => 'other-article-about-it',
            'title' => 'Other article about it',
            'content_preview' => $lorem['preview'],
            'content_detail' => $lorem['detail'],
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
            'content_preview' => $lorem['preview'],
            'content_detail' => $lorem['detail'],
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
            'content_preview' => $lorem['preview'],
            'content_detail' => $lorem['detail'],
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
        echo "m150623_151118_feed_demo_data cannot be reverted.\n";

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