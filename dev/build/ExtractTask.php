<?php
/**
 * ExtractTask.php
 * @author Revin Roman
 * @link https://rmrevin.ru
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
            'rsync -rt ./components/ ../base/',
            // modules
            'rsync -rt ./modules/Account/ ../module-account/',
            'rsync -rt ./modules/Client/ ../module-client/',
            'rsync -rt ./modules/Feed/ ../module-feed/',
            'rsync -rt ./modules/Media/ ../module-media/',
            'rsync -rt ./modules/Order/ ../module-order/',
            'rsync -rt ./modules/Page/ ../module-page/',
            'rsync -rt ./modules/Postman/ ../module-postman/',
            // project
            'rsync -rt ./common/ ../project/common/',
            'rsync -rt ./frontend-app/ ../project/frontend-app/ --exclude=runtime',
            'rsync -rt ./frontend-modules/ ../project/frontend-modules/',
            'rsync -rt ./backend-app/ ../project/backend-app/ --exclude=runtime',
            'rsync -rt ./backend-modules/ ../project/backend-modules/',
            'rsync -rt ./crm-app/ ../project/crm-app/ --exclude=runtime',
            'rsync -rt ./crm-modules/ ../project/crm-modules/',
        ];

        // project files
        foreach ($this->projectFiles as $file) {
            $this->commandline[] = sprintf('rsync -t ./%1$s ../project/%1$s', $file);
        }
    }

    public function run()
    {
        $result = parent::run();

        $this->log('<task-result> TASK </task-result> executed.');

        return $result;
    }

    public $projectFiles = [
        '.bowerrc',
        '.env',
        '.env.dist',
        '.gitignore',
        'backend',
        'backend.bat',
        'bower.json',
        'build',
        'build.bat',
        'codecept',
        'codeception.yml',
        'composer.json',
        'crm',
        'crm.bat',
        'env.php',
        'frontend',
        'frontend.bat',
        'generate_self_signed_ssl_key',
        'getcomposer',
        'LICENSE.md',
        'package.json',
        'README.md',
        'requirements.php',
    ];
}