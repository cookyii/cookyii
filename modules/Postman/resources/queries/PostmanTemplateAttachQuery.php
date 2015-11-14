<?php
/**
 * PostmanTemplateAttachQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\queries;

/**
 * Class PostmanTemplateAttachQuery
 * @package cookyii\modules\Postman\resources\queries
 *
 * @method \cookyii\modules\Postman\resources\PostmanTemplateAttach|array|null one($db = null)
 * @method \cookyii\modules\Postman\resources\PostmanTemplateAttach[]|array all($db = null)
 */
class PostmanTemplateAttachQuery extends \yii\db\ActiveQuery
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