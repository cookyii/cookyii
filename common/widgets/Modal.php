<?php
/**
 * Modal.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\widgets;

/**
 * Class Modal
 * @package common\widgets
 */
class Modal extends \yii\bootstrap\Modal
{

    public $content;

    public function run()
    {
        if (is_callable($this->content)) {
            call_user_func($this->content, $this);
        }

        if (is_string($this->content)) {
            echo $this->content;
        }

        parent::run();
    }
}