<?php
/**
 * build.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

if (file_exists(__DIR__ . '/.env.php')) {
    require __DIR__ . '/.env.php';
}

defined('YII_ENV') || define('YII_ENV', 'dev');

require __DIR__ . '/dev/build/InstallTask.php';

/** @var array $apps list of existing applications */
$apps = json_decode(file_get_contents(__DIR__ . '/.apps.json'), true);

/** @var array $config build configuration */
$buildConfig = [
    'default' => [
        '.description' => 'Default build',
        '.depends' => [YII_ENV],
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
            'environment/check',
            'clear',
            'composer/selfupdate', 'composer/install-prod',
            'npm/install', 'bower/update', 'less',
            'migrate', 'rbac',
        ],
    ],

    'demo' => [
        '.description' => 'Build project with demo environment',
        '.depends' => [
            'environment/check',
            'clear',
            'composer/selfupdate', 'composer/install',
            'npm/install', 'bower/update', 'less',
            'migrate', 'rbac',
        ],
    ],

    'dev' => [
        '.description' => 'Build project with developer environment',
        '.depends' => [
            'environment/check',
            'clear',
            'composer/selfupdate', 'composer/install',
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
            'noPlugins' => true,
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
        '.task' => [
            'class' => 'cookyii\build\tasks\CommandTask',
            'commandline' => './node_modules/.bin/gulp css',
        ],
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
