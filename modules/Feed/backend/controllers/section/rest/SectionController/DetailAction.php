<?php
/**
 * DetailAction.php
 * @author Revin Roman
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
        /* @var $modelClass \resources\Feed\Section */
        $modelClass = $this->modelClass;

        /** @var \resources\Feed\queries\SectionQuery $Query */
        $Query = $modelClass::find();

        /** @var \resources\Feed\Section $model */
        $model = $Query->bySlug($slug)
            ->one();

        if (empty($model)) {
            throw new \yii\web\NotFoundHttpException("Object not found: $slug");
        }

        $result = $model->attributes;

//        $result['parent_id'] = (string)$result['parent_id'];

        $meta = $model->meta();
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