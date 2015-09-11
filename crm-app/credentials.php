<?php
/**
 * credentials.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.credentials')) {
    $Credentials = new \Dotenv\Dotenv(__DIR__, '.credentials');
    $Credentials->load();
}
