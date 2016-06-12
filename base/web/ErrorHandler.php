<?php
/**
 * ErrorHandler.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\web;

/**
 * Class ErrorHandler
 * @package cookyii\web
 */
class ErrorHandler extends \yii\web\ErrorHandler
{

    /**
     * @inheritdoc
     */
    protected function convertExceptionToArray($exception)
    {
        $array = parent::convertExceptionToArray($exception);

        if ($exception instanceof ErrorsException) {
            $array['errors'] = $exception->errors;
        }

        return $array;
    }
}
