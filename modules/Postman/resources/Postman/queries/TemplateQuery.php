<?php
/**
 * TemplateQuery.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Postman\queries;

/**
 * Class TemplateQuery
 * @package resources\Postman\queries
 */
class TemplateQuery extends \yii\db\ActiveQuery
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
        $this->andWhere(['deleted' => \resources\Postman\Template::NOT_DELETED]);

        return $this;
    }

    /**
     * @param string $query
     * @return self
     */
    public function search($query)
    {
        $words = explode(' ', $query);

        $this->andWhere([
            'or',
            array_merge(['or'], array_map(function ($value) { return ['like', 'id', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'code', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'subject', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_text', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_html', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'address', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'description', $value]; }, $words)),
        ]);

        return $this;
    }
}