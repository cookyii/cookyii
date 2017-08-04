<?php
/**
 * UpdateTask.php
 * @created 2017-08-04
 */

namespace dev\build;

/**
 * Class UpdateTask
 * @package dev\build
 */
class UpdateTask extends \cookyii\build\tasks\CommandTask
{

    public function init()
    {
        parent::init();

        $cmd = <<<BASH
cd {path}
git pull
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
            str_replace('{path}', '../project/', $cmd),
        ];
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
}
