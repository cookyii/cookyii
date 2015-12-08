<?php
/**
 * config.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

return [
    'sourcePath' => __DIR__ . '/..',
    'messagePath' => __DIR__,
    'languages' => ['en', 'ru', 'de'],
    'translator' => 'Yii::t',
    'sort' => false,
    'overwrite' => true,
    'removeUnused' => false,
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/*/runtime',
        '/vendor/*',
        '!/vendor/cookyii',
    ],
    'only' => ['*.php'],
    'format' => 'php',
];