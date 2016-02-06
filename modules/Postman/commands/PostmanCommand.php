<?php
/**
 * PostmanCommand.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\commands;

use cookyii\modules\Postman\resources\PostmanMessage;
use yii\helpers\Json;

/**
 * Class PostmanCommand
 * @package cookyii\modules\Postman\commands
 */
class PostmanCommand extends \yii\console\Controller
{

    public $defaultAction = 'send';

    /**
     * @param integer $limit
     * @throws \yii\console\Exception
     */
    public function actionSend($limit = 10)
    {
        $this->stdout(sprintf('Looking for the next %d letters to send... ', $limit));

        $Messages = PostmanMessage::find()
            ->forMailQueue()
            ->limit($limit)
            ->all();

        if (empty($Messages)) {
            $this->stdout('messages not found.' . PHP_EOL);
        } else {
            $this->stdout(sprintf('fond %d.', count($Messages)) . PHP_EOL);

            foreach ($Messages as $Message) {
                $this->stdout(sprintf('    > attempt to send message %d...', $Message->id));

                $result = $Message->sendImmediately();

                if ($Message->hasErrors()) {
                    $errors = $Message->getErrors();

                    $this->stderr('an error occurred.' . PHP_EOL);
                    $this->stderr(print_r($errors, 1) . PHP_EOL);

                    $Message->error = Json::encode($errors);
                    $Message->validate() && $Message->save();
                } elseif (is_bool($result) && $result === true) {
                    $this->stdout('send.' . PHP_EOL);
                } elseif (is_bool($result) && $result === false) {
                    $Postman = PostmanMessage::getPostman();

                    $Message->repeatAfter($Postman->resentTry, $Postman->resentOffset);

                    $this->stdout('NOT send.' . PHP_EOL);
                } else {
                    throw new \yii\console\Exception('Emergency response');
                }
            }
        }
    }
}