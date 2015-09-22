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
 *
 * @method \cookyii\modules\Postman\resources\Postman\Message\Attach|array|null one($db = null)
 * @method \cookyii\modules\Postman\resources\Postman\Message\Attach[]|array all($db = null)
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