<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\section\rest\SectionController;

/**
 * Class DetailAction
 * @package cookyii\modules\Feed\backend\controllers\section\rest\SectionController
 */
class DetailAction extends \yii\rest\Action
{

    /**
     * @param string $slug
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($slug)
    {
        /* @var string $ModelClass \cookyii\modules\Feed\resources\Feed\Section */
        $ModelClass = $this->modelClass;

        /** @var \cookyii\modules\Feed\resources\Feed\queries\SectionQuery $Query */
        $Query = $ModelClass::find();

        /** @var \cookyii\modules\Feed\resources\Feed\Section $Model */
        $Model = $Query->bySlug($slug)
            ->one();

        if (empty($Model)) {
            throw new \yii\web\NotFoundHttpException("Object not found: $slug");
        }

        $result = $Model->attributes;

        $meta = $Model->meta();
        if (!empty($meta)) {
            foreach ($meta as $k => $v) {
                $key = sprintf('meta_%s', $k);
                $result[$key] = $v;
            }
        }

        $result['published_at'] = empty($result['published_at'])
            ? null
            : Formatter()->asDatetime($result['published_at'], 'dd.MM.yyyy HH:mm');

        $result['archived_at'] = empty($result['archived_at'])
            ? null
            : Formatter()->asDate($result['archived_at'], 'dd.MM.yyyy');

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}