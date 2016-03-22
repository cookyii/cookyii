<?php

use yii\helpers\Json;

class m150811_172807_account_postman_templates extends \cookyii\db\Migration
{

    public function up()
    {
        $this->insertSignUpMessage('account.frontend.sign-up');
        $this->insertForgotPasswordRequestMessage('account.frontend.forgot-password.request');
        $this->insertForgotPasswordNewPasswordMessage('account.frontend.forgot-password.new-password');
        $this->insertBanMessage('account.frontend.ban');
        $this->insertUnbanMessage('account.frontend.unban');
    }

    public function down()
    {
        $this->delete('{{%postman_template}}', [
            'code' => [
                'account.frontend.unban',
                'account.frontend.ban',
                'account.frontend.forgot-password.new-password',
                'account.frontend.forgot-password.request',
                'account.frontend.sign-up',
            ],
        ]);
    }

    protected function insertSignUpMessage($code)
    {
        $time = time();

        $params = [
            [
                'key' => 'email',
                'description' => 'User email',
            ], [
                'key' => 'password',
                'description' => 'User password',
            ],
        ];

        $content = [
            'text' => 'You have successfully registered on {host}.' . PHP_EOL
                . 'Remember your data:' . PHP_EOL
                . 'Login: {email}' . PHP_EOL
                . 'Password: {password}' . PHP_EOL
                . PHP_EOL
                . 'Attention! No they do not share your password.' . PHP_EOL,
            'html' => '<p>You have successfully registered on <a href="{host}">{host}</a>.</p>' . PHP_EOL
                . '<p>Remember your data:</p>' . PHP_EOL
                . '<p><ul>' . PHP_EOL
                . '    <li>Login: {email}</li>' . PHP_EOL
                . '    <li>Password: {password}</li>' . PHP_EOL
                . '</ul></p>' . PHP_EOL
                . '<p><strong style="color:#dd4b39">Attention!</strong> No they do not share your password.</p>',
        ];

        $this->insert('{{%postman_template}}', [
            'code' => $code,
            'subject' => 'Your registration details',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => null,
            'description' => 'This letter will be sent after the registration of the new user in the frontend.',
            'address' => Json::encode([]),
            'params' => Json::encode($params),
            'use_layout' => 1,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }

    protected function insertForgotPasswordRequestMessage($code)
    {
        $time = time();

        $params = [
            [
                'key' => 'hash',
                'description' => 'Secret code for url',
            ], [
                'key' => 'url',
                'description' => 'Url to reset password',
            ], [
                'key' => 'short_url',
                'description' => 'Short url to reset password',
            ],
        ];

        $content = [
            'text' => 'You requested password recovery on {host}.' . PHP_EOL
                . 'To recover your password, click here:' . PHP_EOL
                . '{url}' . PHP_EOL,
            'html' => '<p>You requested password recovery on <a href="{host}">{host}</a>.</p>' . PHP_EOL
                . '<p>To recover your password, click here:</p>'
                . '<p><a href="{url}">{short_url}</a>.</p>'
                . '<p>Or copy paste this url in your browser.</p>'
                . '<p><textarea style="width:100%;min-height:100px">{url}</textarea></p>',
        ];

        $this->insert('{{%postman_template}}', [
            'code' => $code,
            'subject' => 'Password recovery',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => null,
            'description' => 'This letter will be sent when the user requests password recovery.',
            'address' => Json::encode([]),
            'params' => Json::encode($params),
            'use_layout' => 1,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }

    protected function insertForgotPasswordNewPasswordMessage($code)
    {
        $time = time();

        $params = [
            [
                'key' => 'email',
                'description' => 'User email',
            ], [
                'key' => 'password',
                'description' => 'User password',
            ],
        ];

        $content = [
            'text' => 'Your login and new password on {host}:' . PHP_EOL
                . '{email}' . PHP_EOL
                . '{password}' . PHP_EOL
                . PHP_EOL
                . 'Attention! No they do not share your password.' . PHP_EOL,
            'html' => '<p>Your login and new password on <a href="{host}">{host}</a>:</p>' . PHP_EOL
                . '<p><ul>' . PHP_EOL
                . '    <li>{email}</li>' . PHP_EOL
                . '    <li>{password}</li>' . PHP_EOL
                . '</ul></p>' . PHP_EOL
                . '<p><strong style="color:#dd4b39">Attention!</strong> No they do not share your password.</p>',
        ];

        $this->insert('{{%postman_template}}', [
            'code' => $code,
            'subject' => 'Your new password',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => null,
            'description' => 'This letter will be sent when you need to send a new password',
            'address' => Json::encode([]),
            'params' => Json::encode($params),
            'use_layout' => 1,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }

    protected function insertBanMessage($code)
    {
        $time = time();

        $params = [
            [
                'key' => 'email',
                'description' => 'User email',
            ],
        ];

        $content = [
            'text' => 'Your account is blocked on {host}.' . PHP_EOL
                . 'We are sorry for inconvenience.' . PHP_EOL,
            'html' => '<p>Your account is blocked on <a href="{host}">{host}</a>.</p>' . PHP_EOL
                . '<p>We are sorry for inconvenience.</p>',
        ];

        $this->insert('{{%postman_template}}', [
            'code' => $code,
            'subject' => 'Your account is blocked',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => null,
            'description' => 'This letter is sent when the user banned',
            'address' => Json::encode([]),
            'params' => Json::encode($params),
            'use_layout' => 1,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }

    protected function insertUnbanMessage($code)
    {
        $time = time();

        $params = [
            [
                'key' => 'email',
                'description' => 'User email',
            ],
        ];

        $content = [
            'text' => 'Congratulations, your account is unblocked on {host}.' . PHP_EOL,
            'html' => '<p>Congratulations, your account is blocked on <a href="{host}">{host}</a>.</p>' . PHP_EOL,
        ];

        $this->insert('{{%postman_template}}', [
            'code' => $code,
            'subject' => 'Your account is unblocked',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => null,
            'description' => 'This letter is sent when the user unbanned',
            'address' => Json::encode([]),
            'params' => Json::encode($params),
            'use_layout' => 1,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }
}