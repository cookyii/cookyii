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
class PushTask extends \cookyii\build\tasks\CommandTask
{

    public function init()
    {
        parent::init();

        $cmd = <<<BASH
cd {path}
git add .
git commit -am "Update" 
git push origin master
BASH;


        $this->commandline = [
            str_replace('{path}', '../base/', $cmd),
            str_replace('{path}', '../module-account/', $cmd),
            str_replace('{path}', '../module-client/', $cmd),
            str_replace('{path}', '../module-feed/', $cmd),
            str_replace('{path}', '../module-media/', $cmd),
            // str_replace('{path}', '../module-order/', $cmd), // this package not exists
            str_replace('{path}', '../module-page/', $cmd),
            str_replace('{path}', '../module-translation/', $cmd),
            str_replace('{path}', '../module-postman/', $cmd),
            // str_replace('{path}', '../project/', $cmd), // this package is to be processed manually
        ];

        // project files
        foreach ($this->projectFiles as $from => $to) {
            if (!is_string($from)) {
                $from = $to;
            }
            $this->commandline[] = sprintf('rsync -t ./%s ../project/%s', $from, $to);
        }
    }

    /**
     * @return bool
     */
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