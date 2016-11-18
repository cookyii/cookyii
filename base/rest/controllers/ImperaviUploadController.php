<?php
/**
 * ImperaviUploadController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\rest\controllers;

use cookyii\modules\Media\media\UploadedResource as UploadedMediaResource;
use cookyii\modules\Media\resources\Media\Model as MediaModel;
use yii\web\UploadedFile;

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
        $UploadedResource = new UploadedMediaResource([
            'source' => UploadedFile::getInstanceByName('file'),
        ]);

        /** @var MediaModel $MediaModel */
        $MediaModel = \Yii::createObject(MediaModel::class);

        $Media = $MediaModel::push($UploadedResource);

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
        $UploadedResource = new UploadedMediaResource([
            'source' => UploadedFile::getInstanceByName('file'),
        ]);

        /** @var MediaModel $MediaModel */
        $MediaModel = \Yii::createObject(MediaModel::class);

        $Media = $MediaModel::push($UploadedResource);

        if (empty($Media)) {
            throw new \yii\web\ServerErrorHttpException;
        }

        return [
            'filelink' => $Media->image()->resizeByWidth(800)->export(),
        ];
    }
}
