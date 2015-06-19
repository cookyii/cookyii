<?php

use yii\db\mysql\Schema;
use yii\helpers\Json;

class m150619_164200_postman_letter_template extends \components\db\Migration
{

    public function up()
    {
        $this->createTable('{{%postman_letter_template}}', [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING,
            'subject' => Schema::TYPE_TEXT,
            'content_text' => Schema::TYPE_TEXT,
            'content_html' => Schema::TYPE_TEXT,
            'address' => Schema::TYPE_TEXT,
            'params' => Schema::TYPE_TEXT,
            'description' => Schema::TYPE_TEXT,
            'use_layout' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ]);

        $this->createIndex('idx_code', '{{%postman_letter_template}}', ['code'], true);

        $this->createTable('{{%postman_letter_template_attach}}', [
            'letter_template_id' => Schema::TYPE_INTEGER,
            'media_id' => Schema::TYPE_INTEGER,
            'embed' => Schema::TYPE_BOOLEAN,
            'PRIMARY KEY (`letter_template_id`, `media_id`)',
            'FOREIGN KEY (letter_template_id) REFERENCES {{%postman_letter_template}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (media_id) REFERENCES {{%media}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $time = time();

        $params = [
            'subject' => 'Letter subject',
            'content' => 'Letter content',
        ];

        $content = [
            'text' => '<!--Letter header-->' . PHP_EOL
                . '{subject}' . PHP_EOL
                . '----------------------------' . PHP_EOL
                . '{content}' . PHP_EOL
                . PHP_EOL
                . 'Good bye!'
                . '<!--Letter footer-->' . PHP_EOL,
            'html' => '<div class="header">{subject}</div>'
                . '<div class="content">{content}</div>'
                . '<br><div class="footer">Good bye!</div>',
        ];

        $this->insert('{{%postman_letter_template}}', [
            'code' => '.layout',
            'subject' => 'Base layout fod letter',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'params' => Json::encode($params),
            'address' => null,
            'description' => 'This is a special template that is a wrapper for all letters.',
            'use_layout' => 0,
            'created_at' => $time,
            'updated_at' => $time,
            'deleted' => 0,
        ]);

        $params = [
            'param1' => 'This is a variable placeholder',
        ];

        $address = [
            [
                'type' => 0, // filed "reply to"
                'email' => 'support@example.com',
                'name' => 'Support',
            ],
            [
                'type' => 1, // filed "to"
                'email' => 'west.a@example.com',
                'name' => 'Adam West',
            ],
            [
                'type' => 2, // filed "cc"
                'email' => 'bob@example.com',
                'name' => null,
            ],
        ];

        $content = [
            'text' => 'Hello!' . PHP_EOL
                . 'This is an example plain letter.' . PHP_EOL
                . 'This is a variable: {param1}.' . PHP_EOL
                . PHP_EOL
                . 'Good bye!',
            'html' => '<p><strong>Hello!</strong></p>'
                . '<p>This is an example <i>htmk</i> letter.</p>'
                . '<p>This is a variable: <i>{param1}</i>.</p>'
                . '<br><p>Good bye!</p>',
        ];

        $this->insert('{{%postman_letter_template}}', [
            'code' => 'example',
            'subject' => 'Good Day!',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'address' => Json::encode($address),
            'params' => Json::encode($params),
            'description' => 'This is a sample letter template.',
            'use_layout' => 1,
            'created_at' => $time,
            'updated_at' => $time,
            'deleted' => 0,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%postman_letter_template_attach}}');
        $this->dropTable('{{%postman_letter_template}}');
    }
}