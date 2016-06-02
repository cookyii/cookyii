<?php
/**
 * .env.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

// Application
// -----------
define('APP_NAME', 'COOKYII');

// Framework
// ---------
define('YII_DEBUG', false);
define('YII_ENV', 'prod');
define('YII_DEMO_DATA', false);

// Databases
// ---------
define('DB_HOST', '<mysql-user-host>');
define('DB_USER', '<mysql-user-name>');
define('DB_PASS', '<mysql-user-password>');
define('DB_BASE', '<mysql-base-main>');
define('DB_DSN', 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=' . DB_BASE);

// Urls
// ----
define('FRONTEND_URL', 'http://<domain>');
define('BACKEND_URL', 'http://backend.<domain>');

// SMTP
// ----
define('SMTP_HOST', null);
define('SMTP_PORT', 25);
define('SMTP_USER', null);
define('SMTP_PASS', null);
define('SMTP_ENC', 'tls');

// Other
// -----
define('COOKIE_VALIDATION_KEY', '<cookoe-validation-key>');
