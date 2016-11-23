<?php
/**
 * PreparePostmanMessageTemplateTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\migrations\traits;

use yii\helpers\Json;

/**
 * Trait PreparePostmanMessageTemplateTrait
 * @package cookyii\modules\Postman\migrations\traits
 */
trait PreparePostmanMessageTemplateTrait
{

    /**
     * @param string $code
     * @param string $subject
     * @param string $description
     * @param array $content
     * @param array $params
     * @param array $options
     * @return array
     */
    public function preparePostmanMessageTemplate($code, $subject, $description, array $content, array $params = [], array $options = [])
    {
        $time = time();

        return array_merge([
            'code' => $code,
            'subject' => $subject,
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => null,
            'description' => $description,
            'address' => Json::encode([]),
            'params' => Json::encode($params),
            'use_layout' => true,
            'created_at' => $time,
            'updated_at' => $time,
            'deleted_at' => null,
        ], $options);
    }
}
