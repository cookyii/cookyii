<?php
/**
 * UploadController.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\modules\Page\backend\controllers\rest;

use cookyii\modules\Media;

/**
 * Class UploadController
 * @package cookyii\modules\Page\backend\controllers\rest
 */
class UploadController extends \yii\rest\Controller
{

    /**
     * @return array
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionFile()
    {
        $UploadedResource = new Media\media\UploadedResource(\yii\web\UploadedFile::getInstanceByName('file'));

        $Media = \resources\Media::push($UploadedResource);

        if (empty($Media)) {
            throw new \yii\web\ServerErrorHttpException;
        }

        return [
            'filelink' => (string)$Media->image()->resizeByWidth(800),
            'filename' => $Media->origin_name,
        ];
    }

    /**
     * @return array
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionImage()
    {
        $UploadedResource = new Media\media\UploadedResource(\yii\web\UploadedFile::getInstanceByName('file'));

        $Media = \resources\Media::push($UploadedResource);

        if (empty($Media)) {
            throw new \yii\web\ServerErrorHttpException;
        }

        return [
            'filelink' => (string)$Media->image()->resizeByWidth(800),
        ];
    }
}