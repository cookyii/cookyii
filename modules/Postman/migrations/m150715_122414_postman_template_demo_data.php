<?php

use yii\helpers\Json;

class m150715_122414_postman_template_demo_data extends \cookyii\db\Migration
{

    public function up()
    {
        if (!YII_DEMO_DATA) {
            echo 'm150715_122414_postman_template_demo_data skipped.' . PHP_EOL;

            return true;
        }

        $time = time();

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
            'text' => 'This is an example plain letter.' . PHP_EOL
                . 'This is a variable: {param1}.' . PHP_EOL,
            'html' => '<p>This is an example <i>html</i> letter.</p>' . PHP_EOL
                . '<p>This is a variable: <i>{param1}</i>.</p>',
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
        ]);
    }

    public function down()
    {
        echo "m150715_122414_postman_template_demo_data reverted.\n";

        return true;
    }
}