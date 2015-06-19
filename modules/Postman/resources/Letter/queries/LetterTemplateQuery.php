<?php
/**
 * LetterTemplateQuery.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Letter\queries;

/**
 * Class LetterTemplateQuery
 * @package resources\Letter\queries
 */
class LetterTemplateQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $id
     * @return self
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

    /**
     * @param string|array $code
     * @return self
     */
    public function byCode($code)
    {
        $this->andWhere(['code' => $code]);

        return $this;
    }

    /**
     * @return self
     */
    public function withoutDeleted()
    {
        $this->andWhere(['deleted' => \resources\Letter\Template::NOT_DELETED]);

        return $this;
    }
}