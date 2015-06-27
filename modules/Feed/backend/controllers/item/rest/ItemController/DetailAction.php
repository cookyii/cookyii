<?php
/**
 * DetailAction.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\controllers\item\rest\ItemController;

use yii\helpers\ArrayHelper;

/**
 * Class DetailAction
 * @package cookyii\modules\Feed\backend\controllers\item\rest\ItemController
 */
class DetailAction extends \yii\rest\Action
{

    /**
     * @param integer $id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        /** @var \resources\Feed\Item $model */
        $model = $this->findModel($id);

        $result = $model->attributes;

        $item_sections = $model->getItemSections()
            ->asArray()
            ->all();

        $result['sections'] = ArrayHelper::getColumn($item_sections, 'section_id');

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