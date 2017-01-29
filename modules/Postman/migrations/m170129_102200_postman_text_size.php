<?php

class m170129_102200_postman_text_size extends \cookyii\db\Migration
{

    public function up()
    {
        $this->alterColumn('{{%postman_template}}', 'content_text', $this->mediumText());
        $this->alterColumn('{{%postman_template}}', 'content_html', $this->mediumText());

        $this->alterColumn('{{%postman_message}}', 'content_text', $this->mediumText());
        $this->alterColumn('{{%postman_message}}', 'content_html', $this->mediumText());
    }

    public function down()
    {
        $this->alterColumn('{{%postman_message}}', 'content_html', $this->text());
        $this->alterColumn('{{%postman_message}}', 'content_text', $this->text());

        $this->alterColumn('{{%postman_template}}', 'content_html', $this->text());
        $this->alterColumn('{{%postman_template}}', 'content_text', $this->text());

    }
}