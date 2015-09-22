<?php
/**
 * MessageQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\Postman\queries;

/**
 * Class MessageQuery
 * @package cookyii\modules\Postman\resources\Postman\queries
 *
 * @method \cookyii\modules\Postman\resources\Postman\Message|array|null one($db = null)
 * @method \cookyii\modules\Postman\resources\Postman\Message[]|array all($db = null)
 */
class MessageQuery extends \yii\db\ActiveQuery
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
     * @param integer|array $status
     * @return static
     */
    public function byStatus($status)
    {
        $this->andWhere(['status' => $status]);

        return $this;
    }

    /**
     * @return static
     */
    public function onlyNew()
    {
        return $this->byStatus([\cookyii\modules\Postman\resources\Postman\Message::STATUS_NEW]);
    }

    /**
     * @return static
     */
    public function onlyNotSent()
    {
        $this->andWhere(['sent_at' => null]);

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
            array_merge(['or'], array_map(function ($value) { return ['like', 'subject', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_text', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_html', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'address', $value]; }, $words)),
        ]);

        return $this;
    }
}