<?php

class m150711_110823_page_demo_data extends \cookyii\db\Migration
{

    public function up()
    {
        $this->insert('{{%page}}', [
            'slug' => 'about',
            'title' => 'About',
            'content' => '<p>This is `about` page</p>',
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
            'content' => '<p>This is `privacy` page</p>',
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
            'content' => '<p>This is `terms` page</p>',
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
            'content' => '<p>This is `contacts` page</p>',
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
            'content' => '<p>This is `maintain` page</p>',
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
        echo "m150711_110823_page_demo_data reverted.\n";

        return true;
    }
}