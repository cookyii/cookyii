<?php
/**
 * build.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

require __DIR__ . '/dev/build/InstallTask.php';

/** @var array $apps list of existing applications */
$apps = ['frontend', 'backend', 'crm'];

/** Automatic detection applications */
automaticDetectionApplications($apps);

/** @var array $config build configuration */
$buildConfig = [
    'default' => [
        '.description' => 'Default build',
        '.depends' => ['dev'],
    ],

    'map' => [
        '.description' => 'Show map of all tasks in current build config',
        '.task' => 'cookyii\build\tasks\MapTask',
    ],

    'install' => [
        '.task' => [
            'class' => 'dev\build\InstallTask',
            'mysqlUserName' => 'cookyii',
            'database' => [
                'main' => 'cookyii',
            ],
        ],
    ],

    'self' => [
        '.description' => 'Internal tasks',
        '.task' => [
            'class' => 'cookyii\build\tasks\SelfTask',
            'composer' => '../composer.phar',
        ],
    ],

    'prod' => [
        '.description' => 'Build project with production environment',
        '.depends' => [
            'self/update',
            'environment/check',
            'clear',
            'composer/selfupdate', 'composer/update-fxp', 'composer/install-prod',
            'npm/install', 'bower/update', 'less',
            'migrate', 'rbac',
        ],
    ],

    'demo' => [
        '.description' => 'Build project with demo environment',
        '.depends' => [
            'self/update',
            'environment/check',
            'clear',
            'composer/selfupdate', 'composer/update-fxp', 'composer/install',
            'npm/install', 'bower/update', 'less',
            'migrate', 'rbac',
        ],
    ],

    'dev' => [
        '.description' => 'Build project with developer environment',
        '.depends' => [
            'self/update',
            'environment/check',
            'clear',
            'composer/selfupdate', 'composer/update-fxp', 'composer/install',
            'npm/install', 'bower/update', 'less',
            'migrate', 'rbac',
        ],
    ],

    'environment' => [
        'check' => [
            '.description' => 'Check file exists `.environment.php`',
            '.task' => [
                'class' => 'cookyii\build\tasks\FileExistsTask',
                'filename' => '.env.php',
                'message' => 'Warning!' . "\n"
                    . 'Need fill environment file' . "\n"
                    . '%s' . "\n"
                    . 'Template is .env.dist.php',
            ],
        ],
    ],

    'clear' => [
        '.description' => 'Delete all temporary files and remove installed packages',
    ],

    'composer' => [
        '.description' => 'Install all depending composer for development environment (with `required-dev`)',
        '.task' => [
            'class' => 'cookyii\build\tasks\ComposerTask',
            'composer' => '../composer.phar',
        ],
        'update-fxp' => [
            '.description' => 'Update `fxp/composer-asset-plugin`',
            '.task' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'commandline' => '../composer.phar global require "fxp/composer-asset-plugin:~1.1.0"',
            ],
        ],
    ],

    'npm' => [
        '.description' => 'Tasks for npm',
        'install' => [
            '.description' => 'Install all npm dependencies',
            '.task' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'commandline' => 'npm install',
            ],
        ],
        'update' => [
            '.description' => 'Update all npm dependencies',
            '.task' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'commandline' => 'npm update',
            ],
        ],
    ],

    'bower' => [
        '.description' => 'Tasks for bower',
        'install' => [
            '.description' => 'Install all bower dependencies',
            '.task' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'commandline' => './node_modules/.bin/bower install',
            ],
        ],
        'update' => [
            '.description' => 'Update all bower dependencies',
            '.task' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'commandline' => './node_modules/.bin/bower update',
            ],
        ],
    ],

    'less' => [
        '.description' => 'Compile all less styles',
    ],

    'migrate' => [
        '.description' => 'Execute all migrations',
        '.task' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'commandline' => './yii migrate --interactive=0',
        ],
    ],

    'rbac' => [
        '.description' => 'Update rbac rules',
        '.task' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'commandline' => './yii rbac/update',
        ],
    ],
];

// create applications tasks
if (!empty($apps)) {
    foreach ($apps as $app) {
        appendClearTask($buildConfig, 'clear', $app);
        appendLessTask($buildConfig, 'less', $app);
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
 * @param string $app
 */
function appendLessTask(array &$buildConfig, $task_name, $app)
{
    $path = getPath($app);

    $less = $path['assets'] . '/less/styles.less';

    if (file_exists($less)) {
        prepareEmptyTask($buildConfig, $task_name);

        $buildConfig[$task_name]['.depends'][] = sprintf('*/%s', $app);
        $buildConfig[$task_name][$app] = [
            '.description' => sprintf('Compile all less styles for `%s` application', $app),
            '.task' => [
                'class' => 'cookyii\build\tasks\CommandTask',
                'commandline' => [
                    cmd($app, '{node}/gulp less --app {a}'),
                ],
            ],
        ];
    }
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
 * @param string $app
 * @param string $command
 * @return string
 */
function cmd($app, $command)
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