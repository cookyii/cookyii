<?php
/**
 * console.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

$vendor_dir = realpath(__DIR__ . '/../../vendor');

return [
    'vendorPath' => $vendor_dir,
    'extensions' => require($vendor_dir . '/yiisoft/extensions.php'),
];
