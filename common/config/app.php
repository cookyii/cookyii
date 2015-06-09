<?php
/**
 * app.php
 * @author Revin Roman
 */

$vendor_dir = realpath(__DIR__ . '/../../vendor');

return [
    'vendorPath' => $vendor_dir,
    'extensions' => require($vendor_dir . '/yiisoft/extensions.php'),
];
