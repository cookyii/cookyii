<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\section\rest\SectionController;

use cookyii\Decorator as D;

/**
 * Class DetailAction
 * @package cookyii\modules\Feed\backend\controllers\section\rest\SectionController
 */
class DetailAction extends \cookyii\rest\Action
{

    /**
     * @param string $slug
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($slug)
    {
        /* @var $modelClass \cookyii\modules\Feed\resources\FeedSection\Model */
        $modelClass = $this->modelClass;

        $Query = $modelClass::find();

        $Model = $Query->bySlug($slug)
            ->one();

        if (empty($Model)) {
            throw new \yii\web\NotFoundHttpException("Object not found: $slug");
        }

        $result = $Model->toArray([], ['meta']);

        $result['published_at'] = empty($result['published_at'])
            ? null
            : D::Formatter()->asDatetime($result['published_at'], 'dd.MM.yyyy HH:mm');

        $result['archived_at'] = empty($result['archived_at'])
            ? null
            : D::Formatter()->asDate($result['archived_at'], 'dd.MM.yyyy');

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}