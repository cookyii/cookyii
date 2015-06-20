<?php
/**
 * app.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

$config = include __DIR__ . '/../app.php';

if (!isset($config['bootstrap'])) {
    $config['bootstrap'] = [];
}

if (!isset($config['modules'])) {
    $config['modules'] = [];
}

return $config;