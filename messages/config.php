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
    'sort' => true,
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
        '/*/web/assets',
        '/upload',
        '/vendor',
    ],
    'ignoreCategories' => [
        'yii',
        'cookyii',
        'cookyii.account',
        'cookyii.client',
        'cookyii.feed',
        'cookyii.media',
        'cookyii.page',
        'cookyii.postman',
        'cookyii.translation',
    ],
    'only' => ['*.php'],
    'format' => 'php',
];