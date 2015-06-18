<?php
/**
 * .dev.console.php
 * @author Revin Roman
 */

$config = include __DIR__ . '/../console.php';

if (!isset($config['extensions'])) {
    $config['extensions'] = [];
};

$config['extensions'] = array_merge($config['extensions'], include __DIR__ . '/_extensions.php');

return $config;