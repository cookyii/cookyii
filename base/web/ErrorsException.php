<?php
/**
 * ErrorsException.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\web;

/**
 * Class ErrorsException
 * @package cookyii\web
 */
class ErrorsException extends \yii\web\ServerErrorHttpException
{

    public $errors = [];

    /**
     * FormErrorsException constructor.
     * @param array $errors
     * @param string|null $message
     * @param integer|null $code
     * @param \Exception $previous
     */
    public function __construct(array $errors, $message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        if (!empty($errors)) {
            $this->applyErrors($errors);
        }
    }

    /**
     * @param array $errors
     */
    public function applyErrors(array $errors)
    {
        $this->errors = $errors;
    }
}
