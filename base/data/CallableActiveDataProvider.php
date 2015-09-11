<?php
/**
 * CallableActiveDataProvider.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\data;

/**
 * Class CallableActiveDataProvider
 * @package cookyii\data
 */
class CallableActiveDataProvider extends \yii\data\ActiveDataProvider
{

    /** @var callable map function */
    public $mapFunction;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!is_callable($this->mapFunction)) {
            throw new \yii\base\InvalidConfigException('You must specify a function for execution `mapFunction`');
        }
    }

    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        $models = parent::prepareModels();

        return array_map($this->mapFunction, $models);
    }
}