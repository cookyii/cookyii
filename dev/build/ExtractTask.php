<?php
/**
 * ExtractTask.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace dev\build;

/**
 * Class ExtractTask
 * @package dev\build
 */
class ExtractTask extends \cookyii\build\tasks\CommandTask
{

    public function init()
    {
        parent::init();

        $this->commandline = [
            // base
            'rsync -rt ./base/ ../base/',
            // modules
            'rsync -rt ./modules/Account/ ../module-account/',
            'rsync -rt ./modules/Client/ ../module-client/',
            'rsync -rt ./modules/Feed/ ../module-feed/',
            'rsync -rt ./modules/Media/ ../module-media/',
            'rsync -rt ./modules/Order/ ../module-order/',
            'rsync -rt ./modules/Page/ ../module-page/',
            'rsync -rt ./modules/Translation/ ../module-translation/',
            'rsync -rt ./modules/Postman/ ../module-postman/',
            // project
            'rsync -rt ./dev/ ../project/dev/',
            'rsync -rt ./common/ ../project/common/',
            'rsync -rt ./messages/ ../project/messages/',
            'rsync -rt ./conf.d/ ../project/conf.d/',
            'rsync -rt ./console-app/ ../project/console-app/ --exclude=runtime',
            'rsync -rt ./frontend-app/ ../project/frontend-app/ --exclude=runtime',
            'rsync -rt ./frontend-assets/ ../project/frontend-assets/',
            'rsync -rt ./frontend-modules/ ../project/frontend-modules/',
            'rsync -rt ./backend-app/ ../project/backend-app/ --exclude=runtime',
            'rsync -rt ./backend-assets/ ../project/backend-assets/',
            'rsync -rt ./backend-modules/ ../project/backend-modules/',
        ];

        // project files
        foreach ($this->projectFiles as $from => $to) {
            if (!is_string($from)) {
                $from = $to;
            }
            $this->commandline[] = sprintf('rsync -t ./%s ../project/%s', $from, $to);
        }
    }

    public function run()
    {
        $result = parent::run();

        $this->log('<task-result> TASK </task-result> executed.');

        return $result;
    }

    public $projectFiles = [
        '.apps.json',
        '.bowerrc',
        '.env.dist.php',
        '.gitignore',
        'bower.json',
        'prebuild',
        'build',
        'build.php',
        'codecept',
        'codeception.yml',
        'composer.prod.json' => 'composer.json',
        'env.php',
        'generate_self_signed_ssl_key',
        'getcomposer',
        'gulpfile.js',
        'LICENSE.md',
        'package.json',
        'README.md',
        'requirements.php',
        'yii',
        'yii.bat',
    ];
}