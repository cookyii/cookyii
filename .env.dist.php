<?php
/**
 * .env.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

// Framework
// ---------
define('YII_DEBUG', false);
define('YII_ENV', 'prod');
define('YII_DEMO_DATA', false);

// Databases
// ---------
define('DB_HOST', 'localhost');
define('DB_USER', 'cookyii');
define('DB_PASS', null);
define('DB_BASE', 'cookyii');
define('DB_DSN', 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=' . DB_BASE);

// Urls
// ----
define('FRONTEND_URL', 'http://cookyii.lc');
define('BACKEND_URL', 'http://backend.cookyii.lc');
define('CRM_URL', 'http://crm.cookyii.lc');

// SMTP
// ----
define('SMTP_HOST', null);
define('SMTP_PORT', 25);
define('SMTP_USER', null);
define('SMTP_PASS', null);
define('SMTP_ENC', 'tls');

// Other
// -----
define('COOKIE_VALIDATION_KEY', '<generated-key>');
