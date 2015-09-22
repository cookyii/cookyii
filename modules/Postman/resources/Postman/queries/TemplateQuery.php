<?php
/**
 * TemplateQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\Postman\queries;

/**
 * Class TemplateQuery
 * @package cookyii\modules\Postman\resources\Postman\queries
 *
 * @method \cookyii\modules\Postman\resources\Postman\Template|array|null one($db = null)
 * @method \cookyii\modules\Postman\resources\Postman\Template[]|array all($db = null)
 */
class TemplateQuery extends \yii\db\ActiveQuery
{

    use \cookyii\db\traits\query\DeletedQueryTrait;

    /**
     * @param integer|array $id
     * @return static
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

    /**
     * @param string|array $code
     * @return static
     */
    public function byCode($code)
    {
        $this->andWhere(['code' => $code]);

        return $this;
    }

    /**
     * @param string $query
     * @return static
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