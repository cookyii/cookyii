<?php
/**
 * LetterTemplateAttachQuery.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Letter\Template\queries;

/**
 * Class LetterTemplateAttachQuery
 * @package resources\Letter\Template\queries
 */
class LetterTemplateAttachQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $letter_template_id
     * @return self
     */
    public function byLetterTemplateId($letter_template_id)
    {
        $this->andWhere(['letter_template_id' => $letter_template_id]);

        return $this;
    }
}