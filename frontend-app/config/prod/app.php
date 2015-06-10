<?php
/**
 * app.dev.php
 * @author Revin Roman
 */

$config = include __DIR__ . '/../app.php';

if (!isset($config['bootstrap'])) {
    $config['bootstrap'] = [];
}

if (!isset($config['modules'])) {
    $config['modules'] = [];
}

return $config;