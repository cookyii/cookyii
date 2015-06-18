<?php
/**
 * _extensions.php
 * @author Revin Roman http://phptime.ru
 */

$base = realpath(__DIR__ . '/../../..');

return [
    'cookyii/module-account' => [
        'name' => 'cookyii/module-account',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-account' => $base . '/modules/Account'],
    ],
    'cookyii/module-media' => [
        'name' => 'cookyii/module-media',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-media' => $base . '/modules/Media'],
    ],
    'cookyii/module-page' => [
        'name' => 'cookyii/module-page',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-page' => $base . '/modules/Page'],
    ],
];