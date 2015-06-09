<?php
/**
 * env.php
 * @author Revin Roman
 */

$Env = new \Dotenv\Dotenv(__DIR__);
$Env->load();

if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.credentials.env')) {
    $CredentialsEnv = new \Dotenv\Dotenv(__DIR__, '.credentials.env');
    $CredentialsEnv->load();
}

defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG') === 'true');
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV') ?: 'prod');