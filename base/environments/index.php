<?php
/**
 * The manifest of files that are local to specific environment.
 * This file returns a list of environments that the application
 * may be installed under. The returned data must be in the following
 * format:
 *
 * ```php
 * return [
 *     'environment name' => [
 *         'path' => 'directory storing the local files',
 *         'writable' => [
 *             // list of directories that should be set writable
 *         ],
 *     ],
 * ];
 * ```
 */
return [
    'Production' => [
        'path' => 'production',
        'writable' => [
            // handled by composer.json already
        ],
        'executable' => [
            'backend',
            'backend-app/yii',
            'crm',
            'crm-app/yii',
            'web',
            'web-app/yii',
        ],
    ],
    'Demo' => [
        'path' => 'demo',
        'writable' => [
            // handled by composer.json already
        ],
        'executable' => [
            'backend',
            'backend-app/yii',
            'crm',
            'crm-app/yii',
            'web',
            'web-app/yii',
            'codecept',
        ],
    ],
    'Development' => [
        'path' => 'dev',
        'writable' => [
            // handled by composer.json already
        ],
        'executable' => [
            'backend',
            'backend-app/yii',
            'crm',
            'crm-app/yii',
            'web',
            'web-app/yii',
            'codecept',
        ],
    ],
];
