<?php
/**
 * PostmanMessageAttachQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\queries;

/**
 * Class PostmanMessageAttachQuery
 * @package cookyii\modules\Postman\resources\queries
 *
 * @method \cookyii\modules\Postman\resources\PostmanMessageAttach|array|null one($db = null)
 * @method \cookyii\modules\Postman\resources\PostmanMessageAttach[]|array all($db = null)
 */
class PostmanMessageAttachQuery extends \yii\db\ActiveQuery
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