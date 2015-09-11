<?php
/**
 * MessageAttachQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\Postman\Message\queries;

/**
 * Class MessageAttachQuery
 * @package cookyii\modules\Postman\resources\Postman\Message\queries
 */
class MessageAttachQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $letter_id
     * @return static
     */
    public function byLetterId($letter_id)
    {
        $this->andWhere(['letter_id' => $letter_id]);

        return $this;
    }
}