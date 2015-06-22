<?php

use yii\db\mysql\Schema;
use yii\helpers\Json;

class m150619_164200_postman_template extends \components\db\Migration
{

    public function up()
    {
        $this->createTable('{{%postman_template}}', [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING,
            'subject' => Schema::TYPE_TEXT,
            'content_text' => Schema::TYPE_TEXT,
            'content_html' => Schema::TYPE_TEXT,
            'styles' => Schema::TYPE_TEXT,
            'description' => Schema::TYPE_TEXT,
            'address' => Schema::TYPE_TEXT,
            'params' => Schema::TYPE_TEXT,
            'use_layout' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'deleted' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
        ]);

        $this->createIndex('idx_code', '{{%postman_template}}', ['code'], true);

        $this->createTable('{{%postman_template_attach}}', [
            'template_id' => Schema::TYPE_INTEGER,
            'media_id' => Schema::TYPE_INTEGER,
            'embed' => Schema::TYPE_BOOLEAN,
            'PRIMARY KEY (`template_id`, `media_id`)',
            'FOREIGN KEY (template_id) REFERENCES {{%postman_template}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (media_id) REFERENCES {{%media}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $time = time();

        $params = [
            [
                'key' => 'subject',
                'description' => 'Message subject',
            ],
            [
                'key' => 'content',
                'description' => 'Message content',
            ],
        ];

        $content = [
            'text' => '{subject}' . PHP_EOL
                . '----------------------------' . PHP_EOL
                . '{content}' . PHP_EOL
                . PHP_EOL
                . 'Good bye!',
            'html' => '<html>' . PHP_EOL
                . '<head>' . PHP_EOL
                . '    <title>{subject}</title>' . PHP_EOL
                . '</head>' . PHP_EOL
                . '<body>' . PHP_EOL
                . '    <div class="header">{subject}</div>' . PHP_EOL
                . '    <div class="content">{content}</div>' . PHP_EOL
                . '    <br>' . PHP_EOL
                . '     <div class="footer">Good bye!</div>' . PHP_EOL
                . '</body>' . PHP_EOL
                . '</html>',
        ];

        $styles = 'div.header { color: #333; }' . PHP_EOL
            . 'div.footer { font-size: 10px; color: #eee; }';

        $this->insert('{{%postman_template}}', [
            'code' => '.layout',
            'subject' => 'Base layout for message',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => $styles,
            'description' => 'This is a special template that is a wrapper for all letters.',
            'params' => Json::encode($params),
            'address' => null,
            'use_layout' => 0,
            'created_at' => $time,
            'updated_at' => $time,
            'deleted' => 0,
        ]);

        $params = [
            [
                'key' => 'param1',
                'description' => 'This is a variable placeholder',
            ],
        ];

        $address = [
            [
                'type' => '1', // filed "reply to"
                'email' => 'support@example.com',
                'name' => 'Support',
            ],
            [
                'type' => '2', // filed "to"
                'email' => 'west.a@example.com',
                'name' => 'Adam West',
            ],
            [
                'type' => '3', // filed "cc"
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
            'html' => '<p><strong>Hello!</strong></p>' . PHP_EOL
                . '<p>This is an example <i>html</i> letter.</p>' . PHP_EOL
                . '<p>This is a variable: <i>{param1}</i>.</p>' . PHP_EOL
                . '<br><p>Good bye!</p>',
        ];

        $styles = 'p { color: #333; }';

        $this->insert('{{%postman_template}}', [
            'code' => 'example',
            'subject' => 'Good Day!',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => $styles,
            'description' => 'This is a sample letter template.',
            'address' => Json::encode($address),
            'params' => Json::encode($params),
            'use_layout' => 1,
            'created_at' => $time,
            'updated_at' => $time,
            'deleted' => 0,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%postman_template_attach}}');
        $this->dropTable('{{%postman_template}}');
    }
}