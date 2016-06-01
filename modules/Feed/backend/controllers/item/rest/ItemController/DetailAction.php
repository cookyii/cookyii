<?php
/**
 * DetailAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\item\rest\ItemController;

/**
 * Class DetailAction
 * @package cookyii\modules\Feed\backend\controllers\item\rest\ItemController
 */
class DetailAction extends \cookyii\rest\Action
{

    /**
     * @param integer $id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        /** @var \cookyii\modules\Feed\resources\FeedItem $Model */
        $Model = $this->findModel($id);

        $result = $Model->toArray([], ['picture_300', 'sections', 'meta']);

        $result['published_at'] = empty($Model->published_at)
            ? null
            : Formatter()->asDatetime($Model->published_at, 'dd.MM.yyyy HH:mm');

        $result['archived_at'] = empty($Model->archived_at)
            ? null
            : Formatter()->asDate($Model->archived_at, 'dd.MM.yyyy');

        $result['hash'] = sha1(serialize($result));

        return $result;
    }
}