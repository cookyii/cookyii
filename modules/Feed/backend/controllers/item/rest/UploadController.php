<?php
/**
 * UploadController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\item\rest;

use cookyii\modules\Media\media\UploadedResource as UploadedMediaResource;
use cookyii\modules\Media\resources\Media\Model as MediaModel;
use yii\web\UploadedFile;

/**
 * Class UploadController
 * @package cookyii\modules\Feed\backend\controllers\item\rest
 */
class UploadController extends \cookyii\rest\controllers\ImperaviUploadController
{

    /**
     * @return array
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionPicture()
    {
        $Resource = new UploadedMediaResource([
            'source' => UploadedFile::getInstanceByName('file'),
        ]);

        /** @var MediaModel $MediaModel */
        $MediaModel = \Yii::createObject(MediaModel::class);

        $Media = $MediaModel::push($Resource);

        if (empty($Media)) {
            throw new \yii\web\ServerErrorHttpException;
        }

        return [
            'id' => $Media->id,
            'url' => $Media->image()->resizeByWidth(300)->export(),
        ];
    }
}
