<?php

class m150711_110823_page_demo_data extends \cookyii\db\Migration
{

    public function up()
    {
        if (!YII_DEMO_DATA) {
            echo "    > m150711_110823_page_demo_data skipped.\n";

            return true;
        }

        $this->insert('{{%page}}', [
            'slug' => 'about',
            'title' => 'About',
            'content' => $this->getFakerTextBlock(5, [300, 500]),
            'meta' => null,
            'created_by' => null,
            'updated_by' => null,
            'created_at' => time(),
            'updated_at' => time(),
            'activated_at' => time(),
        ]);

        $this->insert('{{%page}}', [
            'slug' => 'privacy',
            'title' => 'Privacy policy',
            'content' => $this->getFakerTextBlock(12, [300, 800]),
            'meta' => null,
            'created_by' => null,
            'updated_by' => null,
            'created_at' => time(),
            'updated_at' => time(),
            'activated_at' => time(),
        ]);

        $this->insert('{{%page}}', [
            'slug' => 'terms',
            'title' => 'Terms of use',
            'content' => $this->getFakerTextBlock(8, [400, 800]),
            'meta' => null,
            'created_by' => null,
            'updated_by' => null,
            'created_at' => time(),
            'updated_at' => time(),
            'activated_at' => time(),
        ]);

        $this->insert('{{%page}}', [
            'slug' => 'contacts',
            'title' => 'Contacts',
            'content' => $this->getFakerTextBlock(2, [100, 200]),
            'meta' => null,
            'created_by' => null,
            'updated_by' => null,
            'created_at' => time(),
            'updated_at' => time(),
            'activated_at' => time(),
        ]);

        $this->insert('{{%page}}', [
            'slug' => 'maintain',
            'title' => 'Maintain',
            'content' => $this->getFakerTextBlock(7, [400, 800]),
            'meta' => null,
            'created_by' => null,
            'updated_by' => null,
            'created_at' => time(),
            'updated_at' => time(),
            'activated_at' => time(),
        ]);
    }

    public function down()
    {
        echo "    > m150711_110823_page_demo_data reverted.\n";

        return true;
    }
}
