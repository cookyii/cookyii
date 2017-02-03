<?php
/**
 * build-dev.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

require __DIR__ . '/dev/build/ExtractTask.php';
require __DIR__ . '/dev/build/PushTask.php';

/** @var array $apps list of existing applications */
$apps = json_decode(file_get_contents(__DIR__ . '/.apps.json'), true);

/** @var array $config build configuration */
$buildConfig = [
    'default' => [
        '.description' => 'Default build',
        '.depends' => ['map'],
    ],

    'map' => [
        '.description' => 'Show map of all tasks in current build config',
        '.task' => 'cookyii\build\tasks\MapTask',
    ],

    'e' => [
        '.depends' => ['extract'],
    ],

    'p' => [
        '.depends' => ['push'],
    ],

    'extract' => [
        '.description' => 'Extract codebase to split projects',
        '.depends' => [
            'clear', 'clear/backups', 'less',
        ],
        '.task' => [
            'class' => 'dev\build\ExtractTask',
        ],
    ],

    'push' => [
        '.description' => 'Push codebase to github repos',
        '.depends' => [
            'extract',
        ],
        '.task' => [
            'class' => 'dev\build\PushTask',
        ],
    ],

    'messages' => [
        '.description' => 'Extract codebase to split repos',
        '.task' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'commandline' => [
                './yii message ./messages/config.php',
                './yii message ./base/messages/config.php',
            ],
        ],
    ],

    'clear' => [
        '.description' => 'Delete all temporary files and remove installed packages',
        'backups' => [
            '.description' => 'Remove all backups',
            '.task' => [
                'class' => 'cookyii\build\tasks\DeleteTask',
                'deleteDir' => false,
                'fileSets' => [
                    ['dir' => __DIR__ . '/.backups', 'exclude' => ['.gitignore']],
                ],
            ],
        ],
    ],

    'less' => [
        '.description' => 'Compile base less styles',
        '.task' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'cwd' => __DIR__ . '/base/assets/_sources',
            'commandline' => __DIR__ . '/node_modules/.bin/gulp css/optimize',
        ],
    ],
];

// create applications tasks
if (!empty($apps)) {
    foreach ($apps as $app) {
        appendClearTask($buildConfig, 'clear', $app);
    }
}

/**
 * @param array $buildConfig
 * @param string $task_name
 * @param string $app
 */
function appendClearTask(array &$buildConfig, $task_name, $app)
{
    prepareEmptyTask($buildConfig, $task_name);

    $appPath = __DIR__ . DIRECTORY_SEPARATOR . sprintf('%s-app', $app);

    $buildConfig[$task_name]['.depends'][] = sprintf('*/%s', $app);
    $buildConfig[$task_name][$app] = [
        '.description' => 'Remove all temp files',
        '.task' => [
            'class' => 'cookyii\build\tasks\DeleteTask',
            'deleteDir' => false,
            'fileSets' => [
                ['dir' => sprintf('%s/runtime', $appPath), 'exclude' => ['.gitignore']],
                ['dir' => sprintf('%s/web/assets', $appPath), 'exclude' => ['.gitignore']],
                ['dir' => sprintf('%s/web/minify', $appPath), 'exclude' => ['.gitignore']],
            ],
        ],
    ];
}

/**
 * @param array $buildConfig
 * @param string $task_name
 */
function prepareEmptyTask(array &$buildConfig, $task_name)
{
    if (!isset($buildConfig[$task_name])) {
        $buildConfig[$task_name] = [];
    }

    if (!isset($buildConfig[$task_name]['.depends'])) {
        $buildConfig[$task_name]['.depends'] = [];
    }
}

return $buildConfig;
