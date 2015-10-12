<?php
/**
 * UploadController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\item\rest;

use cookyii\modules\Media;
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
        $Resource = new Media\media\UploadedResource([
            'source' => UploadedFile::getInstanceByName('file'),
        ]);

        $Media = Media\resources\Media::push($Resource);

        if (empty($Media)) {
            throw new \yii\web\ServerErrorHttpException;
        }

        return [
            'id' => $Media->id,
            'url' => $Media->image()->resizeByWidth(300)->export(),
        ];
    }
}