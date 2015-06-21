<?php
/**
 * MessageAttachQuery.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Postman\Message\queries;

/**
 * Class MessageAttachQuery
 * @package resources\Postman\Message\queries
 */
class MessageAttachQuery extends \yii\db\ActiveQuery
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