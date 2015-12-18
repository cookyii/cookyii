<?php
/**
 * app.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

$base_dir = realpath(__DIR__ . '/../..');
$vendor_dir = realpath($base_dir . '/vendor');

$path_list = [
    $vendor_dir . '/yiisoft/extensions.php',
    $base_dir . '/.extensions.php',
];

$extensions = [];

foreach ($path_list as $path) {
    if (file_exists($path)) {
        $extensions = array_merge($extensions, require_once $path);
    }
}

return [
    'name' => APP_NAME,
    'vendorPath' => $vendor_dir,
    'extensions' => $extensions,
    'language' => 'en',
];
