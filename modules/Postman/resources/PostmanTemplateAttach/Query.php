<?php
/**
 * Query.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\PostmanTemplateAttach;

/**
 * Class Query
 * @package cookyii\modules\Postman\resources\PostmanTemplateAttach
 *
 * @method Model|array|null one($db = null)
 * @method Model[]|array all($db = null)
 */
class Query extends \yii\db\ActiveQuery
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
