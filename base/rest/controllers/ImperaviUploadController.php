<?php
/**
 * ImperaviUploadController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\rest\controllers;

use cookyii\modules\Media;

/**
 * Class ImperaviUploadController
 * @package cookyii\rest\controllers
 */
abstract class ImperaviUploadController extends \yii\rest\Controller
{

    /**
     * @return array
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionFile()
    {
        $UploadedResource = new Media\media\UploadedResource(\yii\web\UploadedFile::getInstanceByName('file'));

        $Media = \cookyii\modules\Media\resources\Media::push($UploadedResource);

        if (empty($Media)) {
            throw new \yii\web\ServerErrorHttpException;
        }

        return [
            'filelink' => (string)$Media->getWebPath(),
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

        $Media = \cookyii\modules\Media\resources\Media::push($UploadedResource);

        if (empty($Media)) {
            throw new \yii\web\ServerErrorHttpException;
        }

        return [
            'filelink' => (string)$Media->image()->resizeByWidth(800),
        ];
    }
}