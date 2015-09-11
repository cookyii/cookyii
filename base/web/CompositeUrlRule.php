<?php
/**
 * CompositeUrlRule.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\web;

/**
 * Class CompositeUrlRule
 * @package cookyii\web
 */
abstract class CompositeUrlRule extends \yii\web\CompositeUrlRule
{

    /**
     * @var array the default configuration of URL rules. Individual rule configurations
     * specified via [[rules]] will take precedence when the same property of the rule is configured.
     */
    public $ruleConfig = ['class' => 'yii\web\UrlRule'];

    /**
     * @return array
     */
    abstract protected function getRules();

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function createRules()
    {
        $rules = [];
        foreach ($this->getRules() as $key => $rule) {
            if (!is_array($rule)) {
                $rule = [
                    'pattern' => $key,
                    'route' => $rule,
                ];
            }

            $rule = \Yii::createObject(array_merge($this->ruleConfig, $rule));
            if (!$rule instanceof \yii\web\UrlRuleInterface) {
                throw new \yii\base\InvalidConfigException('URL rule class must implement UrlRuleInterface.');
            }

            $rules[] = $rule;
        }

        return $rules;
    }
}