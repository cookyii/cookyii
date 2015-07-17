<?php
/**
 * console.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

$config = include __DIR__ . '/../console.php';

if (!isset($config['extensions'])) {
    $config['extensions'] = [];
};

$config['components']['rollbar']['enabled'] = false;

return $config;