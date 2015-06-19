<?php
/**
 * LetterAttachQuery.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Letter\queries;

/**
 * Class LetterAttachQuery
 * @package resources\Letter\queries
 */
class LetterAttachQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $letter_id
     * @return self
     */
    public function byLetterId($letter_id)
    {
        $this->andWhere(['letter_id' => $letter_id]);

        return $this;
    }
}