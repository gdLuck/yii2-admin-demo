<?php
namespace frontend\controllers;

use yii;
use yii\web\Controller;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;


class ImageUploadController extends Controller
{
    public $defaultAction = 'upload';
    
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
                // 文件上传成功
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
}