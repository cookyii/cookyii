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
        /** @var \cookyii\modules\Feed\resources\Feed\Item $Model */
        $Model = $this->findModel($id);

        $result = $Model->toArray([], ['picture_300', 'sections', 'meta']);

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