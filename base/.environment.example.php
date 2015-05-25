<?php
/**
 * .environment.example.php
 * @author Revin Roman http://phptime.ru
 */

define('BASE_PATH', realpath(__DIR__));

/**
 * Environment ID
 * 'prod' (production), 'dev' (development), 'test', 'staging', etc.
 */
defined('YII_ENV') or define('YII_ENV', 'dev');

/** Debug ружим */
defined('YII_DEBUG') or define('YII_DEBUG', true);

/** Нужно ли редиректить пользователя на ssl версию */
define('USE_SSL', false);

/** Домен для версии приложения */
define('DOMAIN_BACKEND', 'backend.myproject.lc');
define('DOMAIN_CRM', 'crm.myproject.lc');
define('DOMAIN_WEB', 'www.myproject.lc');

/** Данные подключения к БД */
define('DB_HOST', 'localhost');
define('DB_USER', 'username');
define('DB_PASS', null);
define('DB_BASE', 'cookyii-app');
define('DB_DSN', 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=' . DB_BASE);

/** Данные подключения к тестовой БД */
define('DB_TEST_USER', 'username');
define('DB_TEST_PASS', null);
define('DB_TEST_BASE', 'cookyii-app');
define('DB_TEST_DSN', 'sqlite:' . BASE_PATH . '/runtime/' . DB_TEST_BASE . '.sq3');

/** Реквизиты smtp сервера */
define('SMTP_HOST', null);
define('SMTP_PORT', 25);
define('SMTP_USER', null);
define('SMTP_PASSWORD', null);
define('SMTP_ENCRYPT', false);

require(__DIR__ . '/globals.php');