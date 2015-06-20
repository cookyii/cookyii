<?php
/**
 * _extensions.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

$base = realpath(__DIR__ . '/../../..');

return [
    'cookyii/module-account' => [
        'name' => 'cookyii/module-account',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-account' => $base . '/modules/Account'],
    ],
    'cookyii/module-page' => [
        'name' => 'cookyii/module-page',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-page' => $base . '/modules/Page'],
    ],
    'cookyii/module-media' => [
        'name' => 'cookyii/module-media',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-media' => $base . '/modules/Media'],
    ],
    'cookyii/module-postman' => [
        'name' => 'cookyii/module-postman',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-postman' => $base . '/modules/Postman'],
    ],
];