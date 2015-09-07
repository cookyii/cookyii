<?php
/**
 * env.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.env.php')) {
    throw new \Exception('Environment file `.env.php` not found.');
} else {
    require_once __DIR__ . DIRECTORY_SEPARATOR . '.env.php';
}