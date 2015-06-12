<?php
/**
 * Serializer.php
 * @author Revin Roman
 */

namespace common\rest;

/**
 * Class Serializer
 * @package common\rest
 */
class Serializer extends \yii\rest\Serializer
{

    /**
     * @inheritdoc
     */
    protected function serializeModels(array $models)
    {
        $models = parent::serializeModels($models);

        $this->response->getHeaders()
            ->set('ETag', sha1(serialize($models)));

        return $models;
    }
}