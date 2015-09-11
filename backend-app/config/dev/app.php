<?php
/**
 * app.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

$config = include __DIR__ . '/../app.php';

if (!isset($config['extensions'])) {
    $config['extensions'] = [];
}

if (!isset($config['bootstrap'])) {
    $config['bootstrap'] = [];
}

if (!isset($config['modules'])) {
    $config['modules'] = [];
}

if (!in_array('debug', $config['bootstrap'], true)) {
    $config['bootstrap'][] = 'debug';
}

if (!isset($config['modules']['debug'])) {
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
}

$config['components']['rollbar']['enabled'] = false;

return $config;