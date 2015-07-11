<?php
/**
 * TemplateAttachQuery.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Postman\Template\queries;

/**
 * Class TemplateAttachQuery
 * @package resources\Postman\Template\queries
 */
class TemplateAttachQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $letter_template_id
     * @return static
     */
    public function byLetterTemplateId($letter_template_id)
    {
        $this->andWhere(['letter_template_id' => $letter_template_id]);

        return $this;
    }
}