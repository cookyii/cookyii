<?php
/**
 * MessageQuery.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources\Postman\queries;

/**
 * Class MessageQuery
 * @package resources\Postman\queries
 */
class MessageQuery extends \yii\db\ActiveQuery
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
     * @param integer|array $status
     * @return self
     */
    public function byStatus($status)
    {
        $this->andWhere(['status' => $status]);

        return $this;
    }

    /**
     * @return self
     */
    public function onlyNew()
    {
        return $this->byStatus([\resources\Postman\Message::STATUS_NEW]);
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
            array_merge(['or'], array_map(function ($value) { return ['like', 'subject', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_text', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_html', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'address', $value]; }, $words)),
        ]);

        return $this;
    }
}