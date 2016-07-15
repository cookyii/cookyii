<?php
/**
 * Query.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\PostmanMessageAttach;

/**
 * Class Query
 * @package cookyii\modules\Postman\resources\PostmanMessageAttach
 *
 * @method Model|array|null one($db = null)
 * @method Model[]|array all($db = null)
 */
class Query extends \yii\db\ActiveQuery
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
