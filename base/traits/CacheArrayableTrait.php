<?php
/**
 * CacheArrayableTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\traits;

use cookyii\Facade as F;

/**
 * Class CacheArrayableTrait
 * @package cookyii\traits
 *
 * @mixin \yii\db\ActiveRecord
 */
trait CacheArrayableTrait
{

    /**
     * @return string
     */
    public function getAttributesHash()
    {
        return sha1(serialize($this->getAttributes()));
    }

    /**
     * @param array $fields
     * @param array $expand
     * @param bool $recursive
     * @return mixed
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $hash = [
            serialize($this->primaryKey),
            serialize($fields),
            serialize($expand),
            serialize($recursive),
            $this->getAttributesHash(),
        ];

        $key = sprintf('active-record-%s-%s', get_called_class(), sha1(implode('|', $hash)));

        $data = F::Cache()->get($key);

        if (empty($data)) {
            $data = parent::toArray($fields, $expand, $recursive);

            F::Cache()->set($key, $data, 3600);
        }

        return $data;
    }
}
