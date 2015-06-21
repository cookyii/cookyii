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

$config['extensions'] = array_merge($config['extensions'], include __DIR__ . '/_extensions.php');

$config['components']['rollbar']['enabled'] = false;

return $config;