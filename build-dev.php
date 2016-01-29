<?php
/**
 * build.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

require __DIR__ . '/dev/build/ExtractTask.php';

/** @var array $apps list of existing applications */
$apps = ['frontend', 'backend', 'crm'];

/** Automatic detection applications */
automaticDetectionApplications($apps);

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

    'extract' => [
        '.description' => 'Extract codebase to split repos',
        '.depends' => [
            'clear', 'less', 'messages',
        ],
        '.task' => [
            'class' => 'dev\build\ExtractTask',
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
    ],

    'less' => [
        '.description' => 'Compile base less styles',
        '.task' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'cwd' => __DIR__ . '/base/assets/_sources',
            'commandline' => cmd('{node}/gulp less'),
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
 * @param string $app
 * @param string|null $key
 * @return array|string|null
 */
function getPath($app, $key = null)
{
    $basePath = __DIR__;
    $appPath = $basePath . DIRECTORY_SEPARATOR . sprintf('%s-app', $app);

    $list = [
        'base' => $basePath,
        'app' => $appPath,
        'assets' => $basePath . DIRECTORY_SEPARATOR . $app . '-assets',
        'node' => $basePath . DIRECTORY_SEPARATOR . 'node_modules' . DIRECTORY_SEPARATOR . '.bin',
    ];

    return empty($key)
        ? $list
        : (isset($list[$key]) ? $list[$key] : null);
}

/**
 * @param array $buildConfig
 * @param string $task_name
 * @param string $app
 */
function appendClearTask(array &$buildConfig, $task_name, $app)
{
    prepareEmptyTask($buildConfig, $task_name);

    $path = getPath($app);

    $buildConfig[$task_name]['.depends'][] = sprintf('*/%s', $app);
    $buildConfig[$task_name][$app] = [
        '.description' => 'Remove all temp files',
        '.task' => [
            'class' => 'cookyii\build\tasks\DeleteTask',
            'deleteDir' => false,
            'fileSets' => [
                ['dir' => sprintf('%s/runtime', $path['app']), 'exclude' => ['.gitignore']],
                ['dir' => sprintf('%s/web/assets', $path['app']), 'exclude' => ['.gitignore']],
                ['dir' => sprintf('%s/web/minify', $path['app']), 'exclude' => ['.gitignore']],
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

/**
 * @param string $command
 * @param string|null $app
 * @return string
 */
function cmd($command, $app = null)
{
    $path = getPath($app);

    $command = str_replace(
        ['{a}'],
        [$app],
        $command
    );

    return str_replace(
        array_map(function ($val) { return sprintf('{%s}', $val); }, array_keys($path)),
        array_values($path),
        $command
    );
}

/**
 * @param array $apps
 */
function automaticDetectionApplications(array &$apps)
{
    $handler = opendir(__DIR__);
    if (is_resource($handler)) {
        while (($file = readdir($handler)) !== false) {
            if (preg_match('|^([a-zA-Z0-9\-]+)\-app$|i', $file, $m)) {
                if (!in_array($m[1], $apps, true)) {
                    $apps[] = $m[1];
                }
            }
        }

        closedir($handler);
    }
}

return $buildConfig;