<?php
/**
 * build.php
 * @author Revin Roman http://phptime.ru
 */

/** path to composer bin (example `./composer.phar` or `composer`) */
define('COMPOSER', '../../composer.phar');

return [
    'map' => [
        'class' => cookyii\build\tasks\MapTask::className(),
        'description' => 'Show map of all tasks in current build config',
    ],

    'default' => [
        'depends' => ['build/dev'],
        'description' => 'Default build',
    ],

    'build' => [
        'prod' => [
            'depends' => ['environment/check', 'clear', 'environment/init/production', 'composer', 'npm', 'less', 'migrate'],
            'description' => 'Build project with production environment',
        ],
        'demo' => [
            'depends' => ['environment/check', 'clear', 'environment/init/demo', 'composer', 'npm', 'less', 'migrate'],
            'description' => 'Build project with demo environment',
        ],
        'dev' => [
            'depends' => ['environment/check', 'clear', 'environment/init', 'composer', 'npm', 'less', 'migrate'],
            'description' => 'Build project with developer environment',
        ],
    ],

    'environment' => [
        'check' => [
            'class' => cookyii\build\tasks\FileExistsTask::className(),
            'description' => 'Check file exists `.environment.php`',
            'filename' => '.environment.php',
            'message' => 'Внимание!' . "\n"
                . 'Необходимо заполнить параметры окружения' . "\n"
                . 'в файле %s' . "\n"
                . 'Шаблон в файле .environment.example.php',
        ],
        'init' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Initialize a new environment (manual selection)',
            'commandline' => './init',
            'production' => [
                'class' => cookyii\build\tasks\CommandTask::className(),
                'description' => 'Initialize a new environment (selected Production)',
                'commandline' => './init --env=Production --force',
            ],
            'demo' => [
                'class' => cookyii\build\tasks\CommandTask::className(),
                'description' => 'Initialize a new environment (selected Demo)',
                'commandline' => './init --env=Demo --force',
            ],
        ],
    ],

    'composer' => [
        'depends' => ['composer/install-dev'],
        'description' => 'Install all depending composer for development environment (with `required-dev`)',
        'install' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Install all depending for productions environment (without `require-dev`)',
            'commandline' => COMPOSER . ' install --prefer-dist --no-dev',
        ],
        'install-dev' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Install all depending for development environment (with `require-dev`)',
            'commandline' => COMPOSER . ' install --prefer-dist',
        ],
        'update' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Update all depending for productions environment (without `require-dev`)',
            'commandline' => COMPOSER . ' update --prefer-dist --no-dev',
        ],
        'update-dev' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Update all depending for development environment (with `require-dev`)',
            'commandline' => COMPOSER . ' update --prefer-dist',
        ],
        'selfupdate' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Update composer script',
            'commandline' => COMPOSER . ' selfupdate',
        ],
        'self-update' => [
            'depends' => ['composer/selfupdate'],
            'description' => 'Update composer script',
        ]
    ],

    'npm' => [
        'class' => cookyii\build\tasks\CommandTask::className(),
        'description' => 'Install all npm and bower dependencies',
        'commandline' => 'npm install',
    ],

    'less' => [
        'depends' => ['less/frontend', 'less/backend', 'less/crm'],
        'description' => 'Compile all less styles',
        'frontend' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Compile all less styles for `frontend` application',
            'commandline' => [
                './node_modules/.bin/lessc --source-map-map-inline frontend-app/_assets/_sources/less/styles.less > frontend-app/_assets/_sources/css/styles-raw.css',
                './node_modules/.bin/autoprefixer frontend-app/_assets/_sources/css/styles-raw.css -o frontend-app/_assets/_sources/css/styles.css',
                './node_modules/.bin/csso -i frontend-app/_assets/_sources/css/styles.css -o frontend-app/_assets/_sources/css/styles-o.css',
            ],
        ],
        'backend' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Compile all less styles for `backend` application',
            'commandline' => [
                './node_modules/.bin/lessc --source-map-map-inline backend-app/_assets/_sources/less/styles.less > backend-app/_assets/_sources/css/styles-raw.css',
                './node_modules/.bin/autoprefixer backend-app/_assets/_sources/css/styles-raw.css -o backend-app/_assets/_sources/css/styles.css',
                './node_modules/.bin/csso -i backend-app/_assets/_sources/css/styles.css -o backend-app/_assets/_sources/css/styles-o.css',
            ],
        ],
        'crm' => [
            'class' => cookyii\build\tasks\CommandTask::className(),
            'description' => 'Compile all less styles for `backend` application',
            'commandline' => [
                './node_modules/.bin/lessc --source-map-map-inline crm-app/_assets/_sources/less/styles.less > crm-app/_assets/_sources/css/styles-raw.css',
                './node_modules/.bin/autoprefixer crm-app/_assets/_sources/css/styles-raw.css -o crm-app/_assets/_sources/css/styles.css',
                './node_modules/.bin/csso -i crm-app/_assets/_sources/css/styles.css -o crm-app/_assets/_sources/css/styles-o.css',
            ],
        ],
    ],

    'migrate' => [
        'class' => cookyii\build\tasks\CommandTask::className(),
        'description' => 'Run database migration',
        'commandline' => './frontend migrate --interactive=0',
    ],

    'clear' => [
        'depends' => ['clear/frontend', 'clear/backend', 'clear/crm'],
        'description' => 'Delete all temporary files and remove installed packages',
        'frontend' => [
            'class' => cookyii\build\tasks\DeleteTask::className(),
            'description' => 'Remove all temporary files from `frontend` application',
            'deleteDir' => false,
            'fileSets' => [
                [
                    'dir' => 'frontend-app/runtime',
                    'exclude' => ['.gitignore'],
                ], [
                    'dir' => 'frontend-app/web/assets',
                    'exclude' => ['.gitignore'],
                ], [
                    'dir' => 'frontend-app/web/minify',
                    'exclude' => ['.gitignore'],
                ],
            ],
        ],
        'backend' => [
            'class' => cookyii\build\tasks\DeleteTask::className(),
            'description' => 'Remove all temporary files from `backend` application',
            'deleteDir' => false,
            'fileSets' => [
                [
                    'dir' => 'backend-app/runtime',
                    'exclude' => ['.gitignore'],
                ], [
                    'dir' => 'backend-app/web/assets',
                    'exclude' => ['.gitignore'],
                ], [
                    'dir' => 'backend-app/web/minify',
                    'exclude' => ['.gitignore'],
                ],
            ],
        ],
        'crm' => [
            'class' => cookyii\build\tasks\DeleteTask::className(),
            'description' => 'Remove all temporary files from `crm` application',
            'deleteDir' => false,
            'fileSets' => [
                [
                    'dir' => 'crm-app/runtime',
                    'exclude' => ['.gitignore'],
                ], [
                    'dir' => 'crm-app/web/assets',
                    'exclude' => ['.gitignore'],
                ], [
                    'dir' => 'crm-app/web/minify',
                    'exclude' => ['.gitignore'],
                ],
            ],
        ],
    ],
];