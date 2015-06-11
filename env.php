<?php
/**
 * env.php
 * @author Revin Roman
 */

$Env = new \Dotenv\Dotenv(__DIR__);
$Env->load();

defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG') === 'true');
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV') ?: 'prod');